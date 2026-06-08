<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;

class ProfileController extends Controller
{
   public function index()
    {
        $staffSession = session('staff');

        if (!$staffSession) {
            return redirect()->route('login');
        }

        $staff = Staff::with('role')->find($staffSession['id']);

        if (!$staff) {
            session()->forget('staff');
            return redirect()->route('login');
        }

       
        return view('admin.profile.index', compact('staff'));
    }
   public function update(Request $request)
{
    $staffSession = session('staff');

    if (!$staffSession) {
        return redirect()->route('login');
    }

    $staff = Staff::find($staffSession['id']);

    if (!$staff) {
        session()->forget('staff');
        return redirect()->route('login');
    }

    $request->validate([
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'name'  => 'nullable|string|max:255',
        'email' => 'nullable|email'
    ]);

    if ($request->filled('name')) {
        $staff->name = $request->name;
    }

    if ($request->filled('email')) {
        $staff->email = $request->email;
    }

    if ($request->hasFile('photo')) {
        $file = $request->file('photo');
        $filename = time().'_'.$file->getClientOriginalName();

        $file->move(public_path('uploads/staff'), $filename);

        $staff->photo = 'uploads/staff/'.$filename;
    }

    $staff->save();

   
    session([
        'staff' => [
            'id' => $staff->id,
            'name' => $staff->name,
            'role' => $staffSession['role'],
            'role_id' => $staffSession['role_id'],
            'branch_id' => $staffSession['branch_id'],
            'photo' => $staff->photo, // WAJIB INI
        ]
    ]);

    return back()->with('success','Profile berhasil diperbarui');
}
}