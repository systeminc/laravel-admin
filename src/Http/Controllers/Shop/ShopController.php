<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    /**
     * Shop index page.
     *
     * @return type
     */
    public function getIndex()
    {
        return view('admin::shop.index');
    }
}
