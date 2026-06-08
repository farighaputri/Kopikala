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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'login_as' => 'required|in:user,admin'
        ]);

        if ($request->login_as === 'admin') {
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

                // ====================================================================
                // STRATEGI DYNAMIC REDIRECT ANTI-403 (BERDASARKAN PERMISSION DATABASE)
                // ====================================================================

                // A. Cek Hak Akses Dashboard Pusat
                if ($staff->role_id == 1 || $staff->role?->name === 'Master Admin' || $staff->hasPermission('Main Dashboard')) {
                    return redirect()->route('dashboard')->with('success', 'Selamat datang kembali, Admin Pusat!');
                }

                // B. Cek Hak Akses Dashboard Cabang Semeru
                if ($staff->hasPermission('Semeru Dashboard')) {
                    return redirect()->route('semeru.dashboard')->with('success', 'Selamat datang di Panel Cabang Semeru!');
                }

                // C. Cek Hak Akses Dashboard Cabang Djuanda
                if ($staff->hasPermission('Djuanda Dashboard')) {
                    return redirect()->route('djuanda.dashboard')->with('success', 'Selamat datang di Panel Cabang Djuanda!');
                }

                // D. Fallback Kasir / Staff Transaksi Lapangan
                if ($staff->hasPermission('Semeru Transaction')) {
                    return redirect()->route('semeru.transaction')->with('success', 'Login Berhasil! Selamat Bekerja.');
                }

                if ($staff->hasPermission('Djuanda Transaction')) {
                    return redirect()->route('djuanda.transaction')->with('success', 'Login Berhasil! Selamat Bekerja.');
                }

                if ($staff->hasPermission('Main Transaction')) {
                    return redirect()->route('transactions.index')->with('success', 'Login Berhasil!');
                }

                // E. Fallback Staff Gudang / Logistik (Akses Stok)
                if ($staff->hasPermission('Stock')) {
                    return redirect()->route('stock.index')->with('success', 'Login Berhasil! Silakan periksa inventaris bahan baku.');
                }

                // F. Fallback Pengaman Akhir (Profile Staff)
                return redirect()->route('admin.profile')->with('success', 'Login berhasil! Silakan lengkapi profil Anda.');
            }

            return back()->with([
                'error' => 'Email atau password admin salah, atau akun tidak aktif.'
            ])->withInput();
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