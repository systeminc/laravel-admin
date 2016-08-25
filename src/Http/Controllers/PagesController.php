<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use View;

class PagesController extends Controller
{
    public function __construct()
    {
        // head meta defaults
        View::share('head', [
            'title'       => 'SystemInc Admin Panel',
            'description' => '',
            'keywords'    => '',
        ]);
    }

    /**
     * Pages controller index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('admin::pages.index');
    }
}
