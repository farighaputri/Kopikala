<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $roles = Role::query();

        if ($request->name) {
            $roles->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->status !== null && $request->status !== '') {
            $roles->where('status', $request->status);
        }

        $roles = $roles->orderBy('name')->get();

        return view('roles.index', compact('roles'));
    }

    // ================= CREATE =================
    public function create()
    {
        $permissions = Permission::orderBy('name')->get();
        return view('roles.create', compact('permissions'));
    }

    // ================= STORE (MENANGKAP REQUEST ACCESS) =================
   // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'status' => 'required|boolean',
            'access' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request) {
            $permissionNames = $request->input('access', []);

            $role = Role::create([
                'name'   => $request->name,
                'status' => $request->status,
                'access' => $permissionNames,
            ]);

            if (!empty($permissionNames)) {
                $permissionIds = Permission::whereIn('name', $permissionNames)
                                           ->pluck('id')
                                           ->toArray();
                $role->permissions()->attach($permissionIds);
            }
        });

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan');
    }
    // ================= SHOW =================
    public function show(Role $role)
    {
        $role->load('permissions');
        return view('roles.show', compact('role'));
    }

    // ================= EDIT =================
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get();
        $role->load('permissions');
        return view('roles.edit', compact('role', 'permissions'));
    }

    // ================= UPDATE (MENANGKAP REQUEST ACCESS) =================
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
            'status' => 'required|boolean',
            'access' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $role) {
            $permissionNames = $request->input('access', []);

            $role->update([
                'name'   => $request->name,
                'status' => $request->status,
                'access' => $permissionNames, 
            ]);

            $permissionIds = [];
            if (!empty($permissionNames)) {
                $permissionIds = Permission::whereIn('name', $permissionNames)
                                           ->pluck('id')
                                           ->toArray();
            }

            $role->permissions()->sync($permissionIds);
        });

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui');
    }

    // ================= DESTROY =================
    public function destroy(Role $role)
    {
        if ($role->staffs()->count() > 0) {
            return back()->with('error', 'Role masih digunakan user');
        }

        $role->permissions()->detach();
        $role->delete();

        return back()->with('success', 'Role berhasil dihapus');
    }
}