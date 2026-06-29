<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('frontend.profile.show', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // VALIDASI (Diubah menjadi nullable agar tidak crash jika input tidak terkirim/disabled)
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ======================
        // UPLOAD FOTO
        // ======================
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatar', 'public');

            // update database
            $user->avatar = $path;
            $user->save();

            // update session admin/staff jika ada
            $staff = session('staff');
            if ($staff) {
                $staff['avatar'] = $path;
                session(['staff' => $staff]);
            }
        }

        // ======================
        // USER MANUAL (Hanya diisi jika input name & email dikirim dan tidak kosong)
        // ======================
        if (!$user->google_id) {
            if ($request->filled('name')) {
                $user->name = $request->name;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
        }

        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'name'   => $user->name,
                'email'  => $user->email,
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : asset('media/default-avatar.png')
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}