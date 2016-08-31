<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    /**
     * Shop index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('admin::shop.index');
    }
}
