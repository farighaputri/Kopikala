<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class BranchController extends Controller
{
    /**
     * List Branch
     */
    public function index()
    {
        $branches = Branch::latest()->get();
        return view('branch.index', compact('branches'));
    }

    /**
     * Form Add Branch
     */
    public function create()
    {
        return view('branch.create');
    }

    /**
     * Store Branch
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'location'    => 'required|string|max:255',
        ]);

        Branch::create([
            'branch_name' => $request->branch_name,
            'location'    => $request->location,
        ]);

        return redirect()->route('branch.index')
            ->with('success', 'Branch berhasil ditambahkan');
    }

    /**
     * Show Detail Branch
     */
    public function show($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branch.show', compact('branch'));
    }

    /**
     * Form Edit Branch
     */
    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        return view('branch.edit', compact('branch'));
    }

    /**
     * Update Branch
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'location'    => 'required|string|max:255',
        ]);

        $branch = Branch::findOrFail($id);
        $branch->update([
            'branch_name' => $request->branch_name,
            'location'    => $request->location,
        ]);

        return redirect()->route('branch.index')
            ->with('success', 'Branch berhasil diperbarui');
    }

    /**
     * Delete Branch
     */
    public function destroy($id)
    {
        Branch::findOrFail($id)->delete();

        return redirect()->route('branch.index')
            ->with('success', 'Branch berhasil dihapus');
    }
}
