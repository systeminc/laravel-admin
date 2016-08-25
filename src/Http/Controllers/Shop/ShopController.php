<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function getIndex()
    {
        return view('admin::shop.index');
    }
}
