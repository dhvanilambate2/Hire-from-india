<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public static function redirectTo()
    {
        $user = auth()->user();

        return match ($user->role) {
            'freelancer' => '/freelancer/dashboard',
            'employer' => '/employer/dashboard',
            'admin' => '/admin/dashboard',
            default => '/dashboard',
        };
    }
}
