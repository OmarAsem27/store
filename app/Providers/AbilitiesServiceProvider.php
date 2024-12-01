<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AbilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // \Log::info('AbilitiesServiceProvider booted');
    }
}
