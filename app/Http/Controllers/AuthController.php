<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff; 
use App\Models\User;  
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // ==========================================
    // 1. DISPLAY LOGIN PAGE
    // ==========================================
    public function showLogin()
    {
        return view('auth.login');
    }

    // ==========================================
    // 2. INTERNAL STAFF/ADMIN LOGIN PROCESS
    // ==========================================
// ==========================================
    // 2. INTERNAL STAFF/ADMIN & USER LOGIN PROCESS
    // ==========================================
    // ==========================================
    // 2. INTERNAL STAFF/ADMIN & USER LOGIN PROCESS
    // ==========================================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'login_as' => 'required|in:user,admin'
        ]);

        // === LOGIKA LOGIN ADMIN / STAFF ===
        if ($request->login_as === 'admin') {
            // 1. Cek apakah email terdaftar di tabel Staff
            $staff = Staff::where('email', $request->email)->first();
            
            if (!$staff) {
                return back()->with([
                    'error' => 'Email atau password salah.'
                ])->withInput($request->only('email'));
            }

            // 2. Jika akun ada, cek apakah statusnya tidak aktif
            if ($staff->status !== 'active') {
                return back()->with([
                    'error' => 'Akun Anda tidak aktif, hubungi master admin.'
                ])->withInput($request->only('email'));
            }

            // 3. Jika aktif, coba lakukan proses otentikasi password
            if (Auth::guard('staff')->attempt([
                'email' => $request->email,
                'password' => $request->password,
                'status' => 'active'
            ])) {

                $request->session()->regenerate();
                $staff = Auth::guard('staff')->user();

                // Simpan data staff ke session untuk mendukung view lama
                session([
                    'staff' => [
                        'id' => $staff->id,
                        'name' => $staff->name,
                        'role' => $staff->role?->name,
                        'role_id' => $staff->role_id,
                        'branch_id' => $staff->branch_id,
                        'photo' => $staff->photo
                    ]
                ]);

                // STRATEGI DYNAMIC REDIRECT
                if ($staff->role_id == 1 || $staff->role?->name === 'Master Admin' || $staff->hasPermission('Main Dashboard')) {
                    return redirect()->route('dashboard')->with('success', 'Selamat datang kembali, Admin Pusat!');
                }

                if ($staff->hasPermission('Semeru Dashboard')) {
                    return redirect()->route('semeru.dashboard')->with('success', 'Selamat datang di Panel Cabang Semeru!');
                }

                if ($staff->hasPermission('Djuanda Dashboard')) {
                    return redirect()->route('djuanda.dashboard')->with('success', 'Selamat datang di Panel Cabang Djuanda!');
                }

                if ($staff->hasPermission('Semeru Transaction')) {
                    return redirect()->route('semeru.transaction')->with('success', 'Login Berhasil! Selamat Bekerja.');
                }

                if ($staff->hasPermission('Djuanda Transaction')) {
                    return redirect()->route('djuanda.transaction')->with('success', 'Login Berhasil! Selamat Bekerja.');
                }

                if ($staff->hasPermission('Main Transaction')) {
                    return redirect()->route('transactions.index')->with('success', 'Login Berhasil!');
                }

                if ($staff->hasPermission('Stock')) {
                    return redirect()->route('stock.index')->with('success', 'Login Berhasil! Silakan periksa inventaris bahan baku.');
                }

                return redirect()->route('admin.profile')->with('success', 'Login berhasil! Silakan lengkapi profil Anda.');
            }

            // 4. Jika email terdaftar & aktif, namun password salah
            return back()->with([
                'error' => 'Email atau password salah.'
            ])->withInput($request->only('email'));
        }

       // === LOGIKA LOGIN USER / CUSTOMER ===
        if ($request->login_as === 'user') {
            // 1. Cek apakah email terdaftar di database
            $user = User::where('email', $request->email)->first();

            // JIKA AKUN TIDAK ADA DI DATABASE
            if (!$user) {
                return back()->with([
                    'error' => 'Akun belum terdaftar.'
                ])->withInput($request->only('email', 'login_as'));
            }

            // 2. Jika akun ada, coba verifikasi email & password lewat Auth Guard
            if (Auth::guard('web')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                $request->session()->regenerate();
                return redirect()->route('menu')->with('success', 'Selamat datang kembali!');
            }

            // JIKA AKUN ADA TAPI PASSWORD SALAH
            return back()->with([
                'error' => 'Email atau password salah.'
            ])->withInput($request->only('email', 'login_as'));
        }
    }
    // ==========================================
    // 3. GOOGLE SOCIALITE OAUTH PROCESS (CUSTOMER)
    // ==========================================
    public function redirectToGoogleUser()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallbackUser()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal mengambil data autentikasi dari Google.');
        }

        if (!$googleUser->getEmail()) {
            return redirect('/login')->with('error', 'Email tidak tersedia atau tidak diizinkan oleh Google.');
        }

        // Cari atau buat User baru berdasarkan email dari Google
        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt('google-login') // Default fallback password aman
            ]
        );

        // Login menggunakan default web guard (Customer)
        Auth::guard('web')->login($user);

        return redirect()->route('menu')->with('success', 'Login via Google berhasil!');
    }

    // ==========================================
    // 4. GLOBAL LOGOUT PROCESS
    // ==========================================
    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}