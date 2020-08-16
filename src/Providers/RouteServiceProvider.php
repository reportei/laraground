<?php

namespace Reportei\Laraground\Providers;

use Reportei\Laraground\Route\RouteMethods;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::mixin(new RouteMethods());
    }
}
