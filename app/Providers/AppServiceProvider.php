<?php

namespace App\Providers;

use App\Listeners\deductProductQuantity;
use App\Listeners\EmptyCart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
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
        Validator::extend('filter', function ($attributes, $value, $params) {
            return !in_array(strtolower($value), $params);
        }, "This name is prohibited");

        Paginator::useBootstrapFour();

        Event::listen('orderCreated', deductProductQuantity::class, );
        Event::listen('orderCreated', EmptyCart::class);

    }
}
