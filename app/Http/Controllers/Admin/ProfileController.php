<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;

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
            return response()->json([
                'status' => 'error',
                'message' => 'Sesi Anda telah habis, silakan login kembali.'
            ], 401);
        }

        $staff = Staff::find($staffSession['id']);

        if (!$staff) {
            session()->forget('staff');
            return response()->json([
                'status' => 'error',
                'message' => 'Data staff tidak ditemukan.'
            ], 404);
        }

        // Menggunakan Validator manual agar jika gagal bisa langsung mengembalikan JSON ke Fetch
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name'  => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:staff,email,' . $staff->id
        ], [
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'photo.max'   => 'Ukuran gambar maksimal adalah 2MB.',
            'email.unique'=> 'Alamat email ini sudah digunakan oleh staff lain.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        if ($request->filled('name')) {
            $staff->name = $request->name;
        }

        if ($request->filled('email')) {
            $staff->email = $request->email;
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();

            // Simpan ke direktori publik
            $file->move(public_path('uploads/staff'), $filename);

          
            if ($staff->photo && file_exists(public_path($staff->photo))) {
                @unlink(public_path($staff->photo));
            }

            $staff->photo = 'uploads/staff/'.$filename;
        }

        $staff->save();

       
        session([
            'staff' => [
                'id' => $staff->id,
                'name' => $staff->name,
                'role' => $staffSession['role'] ?? '',
                'role_id' => $staffSession['role_id'] ?? '',
                'branch_id' => $staffSession['branch_id'] ?? '',
                'photo' => $staff->photo,
            ]
        ]);

        
        return response()->json([
            'status' => 'success',
            'message' => 'Profile berhasil diperbarui',
            'data' => [
                'name' => $staff->name,
                'email' => $staff->email,
                'photo' => asset($staff->photo)
            ]
        ]);
    }
}