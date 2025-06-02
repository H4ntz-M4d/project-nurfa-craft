<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        
        // Jika ada X-Forwarded-Proto header, paksa HTTPS
        if (request()->hasHeader('X-Forwarded-Proto') && 
            request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
