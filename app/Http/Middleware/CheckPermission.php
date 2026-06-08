<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // 1. Pastikan staff sudah login menggunakan guard staff
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil objek model Staff yang sedang aktif
        $staff = Auth::guard('staff')->user();

        // 3. Validasi status staff harus aktif
        if ($staff->status !== 'active') {
            Auth::guard('staff')->logout();
            return redirect()->route('login')->with('error', 'Akun Anda sudah dinonaktifkan.');
        }

        // 4. Jalankan fungsi hasPermission dari model Staff
        if (!$staff->hasPermission($permission)) {
            abort(403, 'Anda Tidak Mempunyai Akses Ke Halaman Ini.');
        }

        return $next($request);
    }
}