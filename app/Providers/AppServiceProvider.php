<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\deductProductQuantity;
use App\Listeners\EmptyCart;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
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
        App::setLocale(request('locale', 'en'));
        JsonResource::withoutWrapping(); // for the whole application

        Validator::extend('filter', function ($attributes, $value, $params) {
            return !in_array(strtolower($value), $params);
        }, "This name is prohibited");

        Paginator::useBootstrapFour();

        // Event::listen('orderCreated', deductProductQuantity::class, );
        // Event::listen('orderCreated', EmptyCart::class);
        // Event::listen(OrderCreated::class, deductProductQuantity::class );

        Event::listen(OrderCreated::class, EmptyCart::class);

        // foreach (config('abilities') as $ability_key => $ability_name) {
        foreach (app('abilities') as $ability_key => $ability_name) {
            Gate::define($ability_key, function ($user) use ($ability_key) {
                return $user->hasAbility($ability_key);
            });
        }

    }


}
