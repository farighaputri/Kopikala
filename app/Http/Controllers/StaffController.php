<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

      
    }

    // ================= LIST STAFF =================
    public function index(Request $request)
    {
        $staffs = Staff::with(['role', 'branch'])
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'like', "%{$request->search}%")
                        ->orWhere('email', 'like', "%{$request->search}%");
                });
            })
            ->when($request->role_id, fn($q) => $q->where('role_id', $request->role_id))
            ->when($request->branch_id, fn($q) => $q->where('branch_id', $request->branch_id))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        return view('staff.index', [
            'staffs' => $staffs,
            'roles' => Role::all(),
            'branches' => Branch::all()
        ]);
    }

    // ================= CREATE FORM =================
    public function create()
    {
        return view('staff.create', [
            'roles' => Role::all(),
            'branches' => Branch::all()
        ]);
    }

    // ================= STORE STAFF =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:6',
            'branch_id' => 'required|exists:branches,id',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $role = Role::find($request->role_id);

        
$roleCode = strtoupper(substr($role?->name ?? 'STF', 0, 3));
$year = date('Y');
$prefix = $roleCode . '-' . $year . '-';

$lastStaff = Staff::where('staff_id', 'like', $prefix . '%')
                  ->orderBy('staff_id', 'desc')
                  ->first();

if ($lastStaff) {
    
    $lastNumber = intval(substr($lastStaff->staff_id, -4));
    $count = $lastNumber + 1;
} else {
    
    $count = 1;
}


$staff_id = $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);

        $data = [
            'staff_id' => $staff_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ];

        // PHOTO UPLOAD
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('staff_photos', 'public');
        }

        Staff::create($data);

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil ditambahkan');
    }

    // ================= EDIT =================
    public function edit(Staff $staff)
    {
        return view('staff.edit', [
            'staff' => $staff,
            'roles' => Role::all(),
            'branches' => Branch::all()
        ]);
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'required|exists:branches,id',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['name', 'email', 'role_id', 'branch_id', 'status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // UPDATE PHOTO
        if ($request->hasFile('photo')) {
            if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
                Storage::disk('public')->delete($staff->photo);
            }

            $data['photo'] = $request->file('photo')
                ->store('staff_photos', 'public');
        }

        $staff->update($data);

        return redirect()->route('staff.index')
            ->with('success', 'Staff berhasil diupdate');
    }

    // ================= DELETE =================
    public function destroy(Staff $staff)
    {
        if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
            Storage::disk('public')->delete($staff->photo);
        }

        $staff->delete();

        return back()->with('success', 'Staff berhasil dihapus');
    }

    // ================= DETAIL =================
    public function show(Staff $staff)
    {
        $staff->load(['role', 'branch']);

        return view('staff.show', compact('staff'));
    }

    // ================= DJUANDA =================
    public function djuanda()
    {
        return $this->branchStaff('djuanda');
    }

    // ================= SEMERU =================
    public function semeru()
{
    $branch = Branch::where('branch_name','Semeru')->first();

    $staffs = Staff::with('role','branch')
                   ->where('branch_id', $branch?->id)
                   ->latest()
                   ->get();

    $roles = Role::all();

    return view('semeru.staff', compact('staffs','roles'))
           ->with('branchName','Semeru')
           ->with('readonly', true);
}

    // ================= REUSABLE BRANCH METHOD =================
    private function branchStaff($branchName)
    {
        $branch = Branch::whereRaw('LOWER(branch_name) = ?', [strtolower($branchName)])
            ->first();

        $staffs = Staff::with(['role', 'branch'])
            ->when($branch, fn($q) => $q->where('branch_id', $branch->id))
            ->latest()
            ->get();

        return view(strtolower($branchName) . '.staff', [
            'staffs' => $staffs,
            'roles' => Role::all(),
            'branchName' => ucfirst($branchName),
        ]);
    }
    
}