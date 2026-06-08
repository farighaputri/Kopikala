<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        // pakai guard staff
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}