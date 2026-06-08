<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Http\Request;


class StockController extends Controller
{
    // ================= STOCK UMUM =================
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

    // ================= CREATE =================
    public function create()
{
    // Cuma ambil kategori yang statusnya 1 (Active) saja
    $categories = Category::where('status', 1)->get();
    
    $branches = Branch::all();
    
    return view('stock.create', compact('categories', 'branches'));
}
    public function destroy(Stock $stock)
{
    $stock->delete();
    return back()->with('success', 'Stock berhasil dihapus');
}

    // ================= STORE =================
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

        // Generate stock_id otomatis
        $lastStock = Stock::latest('id')->first();
        $nextId = $lastStock ? $lastStock->id + 1 : 1;
        $validated['stock_id'] = 'STK' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // Total price
        $validated['total_price'] = $validated['qty_purchased'] * $validated['unit_price'];

        // Upload image
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


    /* ================= EDIT ================= */
    public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        return view('stock.edit', [
            'stock' => $stock,
            'categories' => Category::all(),
            'branches' => Branch::all(),
        ]);
    }

    // ================= STOCK PER CABANG =================
 public function branchStock(Request $request, $branchName)
{
    // Ambil branch secara toleran (anti 404 karena beda penamaan)
    $branch = Branch::whereRaw(
        'LOWER(branch_name) LIKE ?',
        ['%' . strtolower($branchName) . '%']
    )->first();

    // Kalau tetap tidak ketemu, hentikan dengan pesan jelas
    if (!$branch) {
        abort(404, 'Branch not found');
    }

    $categories = Category::all();

    $stocksQuery = Stock::with(['categoryRelation','branch'])
        ->where('branch_id', $branch->id);

    // Search
    if ($request->filled('search')) {
        $stocksQuery->where(function($q) use ($request){
            $q->where('stock_id','like',"%{$request->search}%")
              ->orWhere('item_name','like',"%{$request->search}%");
        });
    }

    // Filter category
    if ($request->filled('category')) {
        $stocksQuery->where('category_id', $request->category);
    }

    // Filter status
    if ($request->filled('status')) {
        $stocksQuery->where('status', $request->status);
    }

    $stocks = $stocksQuery->get();

    // ================= SUMMARY =================
    $totalCategories = $categories->count();
    $totalItems      = $stocks->sum('in_stock');
    $totalCost       = $stocks->sum('total_price');
    $lowStockCount   = $stocks->where('status','LOW STOCK')->count();

    // readonly khusus Semeru
    $readonly = strtolower($branch->branch_name) === 'semeru';

    // ===== VIEW SESUAI FILE YANG SUDAH ADA =====
    // djuanda/stock.blade.php atau semeru/stock.blade.php
    $viewName = strtolower($branch->branch_name) . '.stock';

    return view($viewName, compact(
        'stocks',
        'categories',
        'branch',
        'totalCategories',
        'totalItems',
        'totalCost',
        'lowStockCount',
        'readonly'
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

    // ================= DATA CLEAN =================
    $data = [
        'item_name'     => $request->item_name,
        'category_id'   => $request->category_id,
        'branch_id'     => $request->branch_id,
        'qty_purchased' => $request->qty_purchased,
        'unit_price'    => $request->unit_price,
        'in_stock'      => $request->in_stock,
        'status'        => $request->status,
    ];

    // ================= TOTAL PRICE FIX =================
    $data['total_price'] =
        $request->qty_purchased * $request->unit_price;

    // ================= IMAGE FIX =================
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('stock_images', 'public');
    }

    $stock->update($data);

    return redirect()
        ->route('stock.index')
        ->with('success', 'Stock berhasil diupdate');
}
}
