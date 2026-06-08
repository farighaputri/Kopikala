<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /* ======================================================
       INDEX + FILTER
    ====================================================== */
    public function index(Request $request)
    {
        $query = Product::query();

        // FILTER: NAME
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // FILTER: PRICE
        if ($request->filled('price')) {

            // RANGE (0-10000)
            if (str_contains($request->price, '-')) {
                [$min, $max] = explode('-', $request->price);
                $query->whereBetween('price', [(int) $min, (int) $max]);
            }

            // PLUS (50000+)
            if (str_contains($request->price, '+')) {
                $min = str_replace('+', '', $request->price);
                $query->where('price', '>=', (int) $min);
            }
        }

        // FILTER: STATUS
        if ($request->filled('status')) {
            $query->where('status', (int) $request->status);
        }

        $products = $query->latest()->get();

        return view('products.index', compact('products'));
    }

    /* ======================================================
       CREATE
    ====================================================== */
    public function create()
    {
        return view('products.create');
    }

    /* ======================================================
       STORE
    ====================================================== */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status'      => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Simpan product
        $product = Product::create([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'status'      => $request->status,
            'image'       => $imagePath,
        ]);

        // Simpan customization
        if ($request->has('customize')) {
            foreach ($request->customize as $custom) {
                if (!empty($custom['name'])) {

                    $customization = $product->customizations()->create([
                        'name' => $custom['name'],
                    ]);

                    if (!empty($custom['types'])) {
                        foreach ($custom['types'] as $type) {
                            if (!empty($type)) {
                                $customization->options()->create([
                                    'name' => $type,
                                    'price_adjustment' => 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil ditambahkan');
    }

    /* ======================================================
       SHOW
    ====================================================== */
    public function show($id)
    {
        $product = Product::with('customizations.options')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /* ======================================================
       EDIT
    ====================================================== */
    public function edit($id)
    {
        $product = Product::with('customizations.options')->findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /* ======================================================
       UPDATE
    ====================================================== */
    public function update(Request $request, $id)
    {
        $product = Product::with('customizations.options')->findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status'      => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload image baru
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Update product
        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'status'      => $request->status,
            'image'       => $imagePath,
        ]);

        // Hapus customization lama
        foreach ($product->customizations as $customization) {
            $customization->options()->delete();
        }
        $product->customizations()->delete();

        // Simpan customization baru
        if ($request->has('customize')) {
            foreach ($request->customize as $custom) {
                if (!empty($custom['name'])) {

                    $customization = $product->customizations()->create([
                        'name' => $custom['name'],
                    ]);

                    if (!empty($custom['types'])) {
                        foreach ($custom['types'] as $type) {
                            if (!empty($type)) {
                                $customization->options()->create([
                                    'name' => $type,
                                    'price_adjustment' => 0,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil diupdate');
    }

    /* ======================================================
       DELETE
    ====================================================== */
    public function destroy($id)
    {
        $product = Product::with('customizations.options')->findOrFail($id);

        // Hapus customization options
        foreach ($product->customizations as $customization) {
            $customization->options()->delete();
        }

        // Hapus customizations
        $product->customizations()->delete();

        // Hapus product
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product berhasil dihapus');
    }
}