<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class LayoutsController extends Controller
{
    /**
     * Layouts controller index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('admin::layout.index');
    }
}
