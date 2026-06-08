<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Pastikan hanya user login yang bisa akses
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

    // VALIDASI
    $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|email|unique:users,email,' . $user->id,
        'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // ======================
    // UPLOAD FOTO
    // ======================
    if ($request->hasFile('avatar')) {

    $request->validate([
        'avatar' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $path = $request->file('avatar')->store('avatar', 'public');

    // update database
    $user->avatar = $path;
    $user->save();

    // update session admin
    $staff = session('staff');
    $staff['avatar'] = $path;
    session(['staff' => $staff]);
}
    // ======================
    // USER MANUAL
    // ======================
    if (!$user->google_id) {

        $user->name = $request->name;
        $user->email = $request->email;
    }

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui!');
}
}