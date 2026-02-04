<?php

namespace App\Providers;

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
        // Load global helpers (functions declared in app/Helpers/GlobalHelper.php)
        $helper = app_path('Helpers/GlobalHelper.php');
        if (file_exists($helper)) {
            require_once $helper;
        }
    }
}
