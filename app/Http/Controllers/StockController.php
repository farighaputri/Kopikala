<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    // ======================================================
    // STOCK UMUM / PUSAT
    // ======================================================
    public function index(Request $request)
    {
        $categories = Category::all();
        $branches   = Branch::all();

        $stocks = Stock::with(['categoryRelation', 'branch']);

        // Filter search
        if ($request->filled('search')) {
            $stocks = $stocks->where(function($q) use ($request) {
                $q->where('stock_id','like',"%{$request->search}%")
                  ->orWhere('item_name','like',"%{$request->search}%");
            });
        }

        // Filter category
        if ($request->filled('category')) {
            $stocks = $stocks->where('category_id',$request->category);
        }

        // Filter status
        if ($request->filled('status')) {
            $stocks = $stocks->where('status',$request->status);
        }

        // Filter branch
        if ($request->filled('branch_id')) {
            $stocks = $stocks->where('branch_id',$request->branch_id);
        }

        $stocks = $stocks->get();

        // ================= SUMMARY =================
        $totalCategories   = $categories->count();
        $totalItems        = $stocks->sum('in_stock');
        $totalCost         = $stocks->sum('total_price');
        $lowStockCount     = $stocks->where('status','LOW STOCK')->count();

        $prevTotalItems    = session('prev_total_items', $totalItems);
        $prevTotalCost     = session('prev_total_cost', $totalCost);
        $prevLowStockCount = session('prev_low_stock', $lowStockCount);

        session([
            'prev_total_items' => $totalItems,
            'prev_total_cost'  => $totalCost,
            'prev_low_stock'   => $lowStockCount,
        ]);

        return view('stock.index', compact(
            'stocks','categories','branches',
            'totalCategories','totalItems','prevTotalItems',
            'totalCost','prevTotalCost',
            'lowStockCount','prevLowStockCount'
        ));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $branches = Branch::all();
        return view('stock.create', compact('categories', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name'     => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'branch_id'     => 'required|exists:branches,id',
            'qty_purchased' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'in_stock'      => 'required|numeric|min:0',
            'status'        => 'required|in:IN STOCK,LOW STOCK,OUT OF STOCK',
            'image'         => 'nullable|image|max:2048',
        ]);

        $lastStock = Stock::latest('id')->first();
        $nextId = $lastStock ? $lastStock->id + 1 : 1;
        $validated['stock_id'] = 'STK' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        $validated['total_price'] = $validated['qty_purchased'] * $validated['unit_price'];

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('stock_images','public');
        }

        Stock::create($validated);
        return redirect()->route('stock.index')->with('success','Stock berhasil ditambahkan!');
    }

    public function show($id)
    {
        $stock = Stock::with(['categoryRelation', 'branch'])->findOrFail($id);
        return view('stock.show', compact('stock'));
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        return view('stock.edit', [
            'stock' => $stock,
            'categories' => Category::all(),
            'branches' => Branch::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $request->validate([
            'item_name'     => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'branch_id'     => 'required|exists:branches,id',
            'qty_purchased' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'in_stock'      => 'required|numeric|min:0',
            'status'        => 'required|in:IN STOCK,LOW STOCK,OUT OF STOCK',
            'image'         => 'nullable|image|max:2048',
        ]);

        $data = [
            'item_name'     => $request->item_name,
            'category_id'   => $request->category_id,
            'branch_id'     => $request->branch_id,
            'qty_purchased' => $request->qty_purchased,
            'unit_price'    => $request->unit_price,
            'in_stock'      => $request->in_stock,
            'status'        => $request->status,
            'total_price'   => $request->qty_purchased * $request->unit_price
        ];

        if ($request->hasFile('image')) {
            if ($stock->image) { Storage::disk('public')->delete($stock->image); }
            $data['image'] = $request->file('image')->store('stock_images', 'public');
        }

        $stock->update($data);
        return redirect()->route('stock.index')->with('success', 'Stock berhasil diupdate');
    }

    public function destroy(Stock $stock)
    {
        if ($stock->image) { Storage::disk('public')->delete($stock->image); }
        $stock->delete();
        return back()->with('success', 'Stock berhasil dihapus');
    }


    // ======================================================
    // CRUD KHUSUS BRANCH (SEMERU BRANCH) - AUTOMATIC LOCK
    // ======================================================

    public function semeruIndex(Request $request)
    {
        $categories = Category::all();
        $branchId = auth()->user()->branch_id;

        $stocksQuery = Stock::with(['categoryRelation', 'branch'])->where('branch_id', $branchId);

        if ($request->filled('search')) {
            $stocksQuery->where(function($q) use ($request) {
                $q->where('stock_id','like',"%{$request->search}%")
                  ->orWhere('item_name','like',"%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $stocksQuery->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $stocksQuery->where('status', $request->status);
        }

        $stocks = $stocksQuery->get();

        $totalItems    = $stocks->sum('in_stock');
        $totalCost     = $stocks->sum('total_price');
        $lowStockCount = $stocks->where('status','LOW STOCK')->count();

        $prevTotalItems    = session('semeru_prev_total_items', $totalItems);
        $prevTotalCost     = session('semeru_prev_total_cost', $totalCost);
        $prevLowStockCount = session('semeru_prev_low_stock', $lowStockCount);

        session([
            'semeru_prev_total_items' => $totalItems,
            'semeru_prev_total_cost'  => $totalCost,
            'semeru_prev_low_stock'   => $lowStockCount,
        ]);

        return view('semeru.stock.index', compact(
            'stocks', 'categories', 
            'totalItems', 'prevTotalItems',
            'totalCost', 'prevTotalCost',
            'lowStockCount', 'prevLowStockCount'
        ));
    }

    public function semeruCreate()
    {
        $categories = Category::where('status', 1)->get();
        return view('semeru.stock.create', compact('categories'));
    }

    public function storeSemeru(Request $request)
    {
        $request->validate([
            'item_name'     => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'qty_purchased' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'in_stock'      => 'required|numeric|min:0',
            'image'         => 'nullable|image|max:2048',
        ]);

        $branchId = auth()->user()->branch_id;

        $lastStock = Stock::latest('id')->first();
        $nextId = $lastStock ? $lastStock->id + 1 : 1;
        $stock_id = 'STK' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $status = 'OUT OF STOCK';
        if ($request->in_stock > 10) {
            $status = 'IN STOCK';
        } elseif ($request->in_stock > 0) {
            $status = 'LOW STOCK';
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stock_images', 'public');
        }

        Stock::create([
            'stock_id'      => $stock_id,
            'item_name'     => $request->item_name,
            'category_id'   => $request->category_id,
            'branch_id'     => $branchId,
            'qty_purchased' => $request->qty_purchased,
            'unit_price'    => $request->unit_price,
            'total_price'   => $request->qty_purchased * $request->unit_price,
            'in_stock'      => $request->in_stock,
            'status'        => $status,
            'image'         => $imagePath,
        ]);

        return redirect()->route('semeru.stock')->with('success', 'Stock cabang Semeru berhasil ditambahkan!');
    }

    public function semeruShow($id)
    {
        $stock = Stock::with(['categoryRelation', 'branch'])
                      ->where('branch_id', auth()->user()->branch_id)
                      ->findOrFail($id);
        return view('semeru.stock.show', compact('stock'));
    }

    public function semeruEdit($id)
    {
        $stock = Stock::where('branch_id', auth()->user()->branch_id)->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        
        return view('semeru.stock.edit', compact('stock', 'categories'));
    }

    public function semeruUpdate(Request $request, $id)
    {
        $stock = Stock::where('branch_id', auth()->user()->branch_id)->findOrFail($id);

        $request->validate([
            'item_name'     => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'qty_purchased' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'in_stock'      => 'required|numeric|min:0',
            'image'         => 'nullable|image|max:2048',
        ]);

        $status = 'OUT OF STOCK';
        if ($request->in_stock > 10) {
            $status = 'IN STOCK';
        } elseif ($request->in_stock > 0) {
            $status = 'LOW STOCK';
        }

        $data = [
            'item_name'     => $request->item_name,
            'category_id'   => $request->category_id,
            'qty_purchased' => $request->qty_purchased,
            'unit_price'    => $request->unit_price,
            'total_price'   => $request->qty_purchased * $request->unit_price,
            'in_stock'      => $request->in_stock,
            'status'        => $status,
        ];

        if ($request->hasFile('image')) {
            if ($stock->image) { Storage::disk('public')->delete($stock->image); }
            $data['image'] = $request->file('image')->store('stock_images', 'public');
        }

        $stock->update($data);

        return redirect()->route('semeru.stock')->with('success', 'Stock cabang Semeru berhasil diperbarui!');
    }

    public function semeruDestroy($id)
    {
        $stock = Stock::where('branch_id', auth()->user()->branch_id)->findOrFail($id);
        
        if ($stock->image) {
            Storage::disk('public')->delete($stock->image);
        }
        
        $stock->delete();

        return redirect()->route('semeru.stock')->with('success', 'Stock cabang Semeru berhasil dihapus!');
    }


    // ======================================================
    // CRUD KHUSUS BRANCH (DJUANDA BRANCH) - AUTOMATIC LOCK
    // ======================================================

    public function djuandaIndex(Request $request)
    {
        $categories = Category::all();
        
        // Kunci murni mencari cabang bernama Djuanda agar summary akurat
        $branch = Branch::where('branch_name', 'like', '%djuanda%')->first() 
                  ?? Branch::find(auth()->user()->branch_id);

        $stocksQuery = Stock::with(['categoryRelation', 'branch'])->where('branch_id', $branch->id);

        if ($request->filled('search')) {
            $stocksQuery->where(function($q) use ($request) {
                $q->where('stock_id','like',"%{$request->search}%")
                  ->orWhere('item_name','like',"%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $stocksQuery->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $stocksQuery->where('status', $request->status);
        }

        $stocks = $stocksQuery->get();

        $totalItems    = $stocks->sum('in_stock');
        $totalCost     = $stocks->sum('total_price');
        $lowStockCount = $stocks->where('status','LOW STOCK')->count();

        $prevTotalItems    = session('djuanda_prev_total_items', $totalItems);
        $prevTotalCost     = session('djuanda_prev_total_cost', $totalCost);
        $prevLowStockCount = session('djuanda_prev_low_stock', $lowStockCount);

        session([
            'djuanda_prev_total_items' => $totalItems,
            'djuanda_prev_total_cost'  => $totalCost,
            'djuanda_prev_low_stock'   => $lowStockCount,
        ]);

        return view('djuanda.stock.index', compact(
            'stocks', 'categories', 'branch',
            'totalItems', 'prevTotalItems',
            'totalCost', 'prevTotalCost',
            'lowStockCount', 'prevLowStockCount'
        ));
    }

    public function djuandaCreate()
    {
        $categories = Category::where('status', 1)->get();
        return view('djuanda.stock.create', compact('categories'));
    }

    public function storeDjuanda(Request $request)
    {
        $request->validate([
            'item_name'     => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'qty_purchased' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'in_stock'      => 'required|numeric|min:0',
            'image'         => 'nullable|image|max:2048',
        ]);

        // FIX TOTAL: Paksa cari ID Cabang Djuanda murni dari database, 
        // tidak menggunakan auth()->user()->branch_id lagi agar anti-salah-masuk cabang!
        $branch = Branch::where('branch_name', 'like', '%djuanda%')->first();
        $branchId = $branch ? $branch->id : auth()->user()->branch_id;

        $lastStock = Stock::latest('id')->first();
        $nextId = $lastStock ? $lastStock->id + 1 : 1;
        $stock_id = 'STK' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $status = 'OUT OF STOCK';
        if ($request->in_stock > 10) {
            $status = 'IN STOCK';
        } elseif ($request->in_stock > 0) {
            $status = 'LOW STOCK';
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stock_images', 'public');
        }

        Stock::create([
            'stock_id'      => $stock_id,
            'item_name'     => $request->item_name,
            'category_id'   => $request->category_id,
            'branch_id'     => $branchId, // Menggunakan ID Djuanda yang sudah dikunci aman
            'qty_purchased' => $request->qty_purchased,
            'unit_price'    => $request->unit_price,
            'total_price'   => $request->qty_purchased * $request->unit_price,
            'in_stock'      => $request->in_stock,
            'status'        => $status,
            'image'         => $imagePath,
        ]);

        return redirect()->route('djuanda.stock')->with('success', 'Stock cabang Djuanda berhasil ditambahkan!');
    }

    public function djuandaShow($id)
    {
        // Cari ID Djuanda murni untuk validasi data detail
        $branch = Branch::where('branch_name', 'like', '%djuanda%')->first();
        $branchId = $branch ? $branch->id : auth()->user()->branch_id;

        $stock = Stock::with(['categoryRelation', 'branch'])
                      ->where('branch_id', $branchId)
                      ->findOrFail($id);
        return view('djuanda.stock.show', compact('stock'));
    }

    public function djuandaEdit($id)
    {
        // Cari ID Djuanda murni untuk validasi data edit
        $branch = Branch::where('branch_name', 'like', '%djuanda%')->first();
        $branchId = $branch ? $branch->id : auth()->user()->branch_id;

        $stock = Stock::where('branch_id', $branchId)->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('djuanda.stock.edit', compact('stock', 'categories'));
    }

    public function djuandaUpdate(Request $request, $id)
    {
        // Cari ID Djuanda murni untuk proses update data
        $branch = Branch::where('branch_name', 'like', '%djuanda%')->first();
        $branchId = $branch ? $branch->id : auth()->user()->branch_id;

        $stock = Stock::where('branch_id', $branchId)->findOrFail($id);

        $request->validate([
            'item_name'     => 'required|string',
            'category_id'   => 'required|exists:categories,id',
            'qty_purchased' => 'required|numeric|min:0',
            'unit_price'    => 'required|numeric|min:0',
            'in_stock'      => 'required|numeric|min:0',
            'image'         => 'nullable|image|max:2048',
        ]);

        $status = 'OUT OF STOCK';
        if ($request->in_stock > 10) {
            $status = 'IN STOCK';
        } elseif ($request->in_stock > 0) {
            $status = 'LOW STOCK';
        }

        $data = [
            'item_name'     => $request->item_name,
            'category_id'   => $request->category_id,
            'qty_purchased' => $request->qty_purchased,
            'unit_price'    => $request->unit_price,
            'total_price'   => $request->qty_purchased * $request->unit_price,
            'in_stock'      => $request->in_stock,
            'status'        => $status,
        ];

        if ($request->hasFile('image')) {
            if ($stock->image) { Storage::disk('public')->delete($stock->image); }
            $data['image'] = $request->file('image')->store('stock_images', 'public');
        }

        $stock->update($data);

        return redirect()->route('djuanda.stock')->with('success', 'Stock cabang Djuanda berhasil diperbarui!');
    }

    public function djuandaDestroy($id)
    {
        // Cari ID Djuanda murni untuk proses hapus data
        $branch = Branch::where('branch_name', 'like', '%djuanda%')->first();
        $branchId = $branch ? $branch->id : auth()->user()->branch_id;

        $stock = Stock::where('branch_id', $branchId)->findOrFail($id);
        if ($stock->image) { Storage::disk('public')->delete($stock->image); }
        $stock->delete();

        return redirect()->route('djuanda.stock')->with('success', 'Stock cabang Djuanda berhasil dihapus!');
    }


    // ======================================================
    // MANAGEMENT STOCK PER INTERFACE BRANCH BREADCRUMB
    // ======================================================
    public function branchStock(Request $request, $branchName)
    {
        $branch = Branch::whereRaw('LOWER(branch_name) LIKE ?', ['%' . strtolower($branchName) . '%'])->first();

        if (!$branch) {
            abort(404, 'Branch not found');
        }

        $categories = Category::all();
        $stocksQuery = Stock::with(['categoryRelation','branch'])->where('branch_id', $branch->id);

        if ($request->filled('search')) {
            $stocksQuery->where(function($q) use ($request){
                $q->where('stock_id','like',"%{$request->search}%")
                  ->orWhere('item_name','like',"%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $stocksQuery->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $stocksQuery->where('status', $request->status);
        }

        $stocks = $stocksQuery->get();

        // ================= SUMMARY =================
        $totalCategories = $categories->count();
        $totalItems      = $stocks->sum('in_stock');
        $totalCost       = $stocks->sum('total_price');
        $lowStockCount   = $stocks->where('status','LOW STOCK')->count();

        $readonly = strtolower($branch->branch_name) === 'semeru';
        $viewName = strtolower($branch->branch_name) . '.stock.index';

        return view($viewName, compact(
            'stocks', 'categories', 'branch',
            'totalCategories', 'totalItems', 'totalCost', 'lowStockCount', 'readonly'
        ));
    }

    // ================= LAST UPDATED API =================
    public function lastUpdated()
    {
        $latest = Stock::latest('updated_at')->first();
        return response()->json([
            'timestamp' => $latest ? $latest->updated_at->timestamp : null
        ]);
    }
}