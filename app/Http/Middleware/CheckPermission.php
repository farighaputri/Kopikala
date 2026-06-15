<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        
        $staff = Auth::guard('staff')->user();

        
        if ($staff->status !== 'active') {
            Auth::guard('staff')->logout();
            return redirect()->route('login')->with('error', 'Akun Anda sudah dinonaktifkan.');
        }

        
        if (!$staff->hasPermission($permission)) {
            
            return $next($request);
        }

        return $next($request);
    }
}