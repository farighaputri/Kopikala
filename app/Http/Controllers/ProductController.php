<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        // Simpan customization (Disesuaikan dengan input array 'customize' dari Blade)
        if ($request->has('customize')) {
            foreach ($request->customize as $custom) {
                if (!empty($custom['name'])) {
                    // Pakai relasi asli di model Anda (customizations)
                    $customization = $product->customizations()->create([
                        'name' => $custom['name'],
                    ]);

                    if (!empty($custom['types'])) {
                        foreach ($custom['types'] as $type) {
                            if (!empty($type)) {
                                // Pakai relasi asli di model Anda (options)
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
        // Tetap meload relasi database asli
        $product = Product::with('customizations.options')->findOrFail($id);
        
        /**
         * TRICK AGAR BLADE TIDAK ERROR:
         * Kita buat 'alias' property sementara pada object $product agar 
         * variabel $product->customizes dan $customize->types di file Blade 
         * membaca data asli dari database tanpa mengubah kode Blade Anda.
         */
        $product->customizes = $product->customizations;
        foreach($product->customizes as $custom) {
            $custom->types = $custom->options;
        }

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
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
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

        // 1. Bersihkan semua kustomisasi lama agar tidak duplikat sampah
        foreach ($product->customizations as $customization) {
            $customization->options()->delete();
        }
        $product->customizations()->delete();

        // 2. Tulis ulang kustomisasi baru yang dikirim dari form Blade ('customize')
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

        // Hapus file fisik gambar dari storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

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