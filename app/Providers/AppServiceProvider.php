<?php
// filepath: C:\xampp\htdocs\cms\app\Providers\AppServiceProvider.php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $email = Str::lower(
                (string) $request->input('email')
            );

            return Limit::perMinute(5)
                ->by($email . '|' . $request->ip());
        });
    }
}

