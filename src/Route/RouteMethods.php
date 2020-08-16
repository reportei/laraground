<?php

namespace Reportei\Laraground\Route;

use Illuminate\Support\Facades\Route;

class RouteMethods
{
    /**
     * Register laraground routes
     *
     * @param array $options
     * @return callable
     */
    public function laraground()
    {
        Route::get('/laraground', 'Reportei\Laraground\Http\Controllers\LaragroundController@index')->name('laraground.index');
    }
}
