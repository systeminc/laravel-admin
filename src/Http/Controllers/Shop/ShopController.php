<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function __construct()
    {
        if (config('laravel-admin.modules.shop') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
    }

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
