<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /* ======================================================
       INDEX
    ====================================================== */
    public function index()
{
    $categories = Category::withCount('stocks')->get();
    return view('categories.index', compact('categories'));
}

public function create()
{
    return view('categories.create');
}

public function store(Request $request)
{
    $request->validate([
        'name'   => 'required|string|max:255|unique:categories,name',
        'status' => 'required|in:0,1',
    ]);

    Category::create([
        'name'   => $request->name,
        'status' => (int) $request->status,
    ]);

    return redirect()->route('categories.index')->with('success', 'Category berhasil ditambahkan');
}

public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('categories.edit', compact('category'));
}

public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $request->validate([
        'name'   => 'required|string|max:255|unique:categories,name,' . $category->id,
        'status' => 'required|in:0,1',
    ]);

    $category->update([
        'name'   => $request->name,
        'status' => (int) $request->status,
    ]);

    return redirect()->route('categories.index')->with('success', 'Category berhasil diupdate');
}

public function destroy($id)
{
    $category = Category::findOrFail($id);

    if ($category->stocks()->exists()) {
        return redirect()->route('categories.index')
            ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki item produk!');
    }

    $category->delete();

    return redirect()->route('categories.index')->with('success', 'Category berhasil dihapus');
}
}