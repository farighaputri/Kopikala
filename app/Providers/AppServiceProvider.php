<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom Directive untuk ngecek permission Staff
        Blade::if('permission', function ($permission) {
            // Cek apakah staff sudah login lewat guard staff
            if (Auth::guard('staff')->check()) {
                // Panggil method hasPermission() dari model Staff
                return Auth::guard('staff')->user()->hasPermission($permission);
            }
            return false;
        });
    }
}