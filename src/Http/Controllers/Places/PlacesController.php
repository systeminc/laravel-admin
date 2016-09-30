<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    public function __construct()
    {
        if (config('laravel-admin.modules.places') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
    }

    /**
     * Show all locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('admin::places.index');
    }
}
