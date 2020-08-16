<?php

namespace Reportei\Laraground\Http\Controllers;

class LaragroundController
{
    public function index()
    {
        return view()->make('vendor.laraground.tailwind.laraground');
    }
}
