<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Pastikan staff sudah login
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('login');
        }

        $staff = Auth::guard('staff')->user();

        // 2. KUNCI BYPASS MASTER ADMIN
        if ($staff->role?->name === 'Master Admin' || $staff->role_id == 1) {
            return $next($request);
        }

        // 3. Cek apakah nama role staff ada di parameter middleware
        if (!in_array($staff->role?->name, $roles)) {
            abort(403, 'Anda Tidak Mempunyai Akses Ke Halaman Ini');
        }

        return $next($request);
    }
}