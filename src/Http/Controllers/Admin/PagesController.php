<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

class PagesController extends Controller
{
	public function __construct()
    {
        // head meta defaults
        View::share('head', [
            'title' => 'SystemInc Admin Panel',
            'description' => '',
            'keywords' => '',
        ]);
    }

    /**
     * Pages controller index page
     * @return type
     */
	public function getIndex()
	{
		return view('admin.pages.index');
	}

	/**
	 * Create new pages
	 * @return type
	 */
	public function getCreate()
	{
		return view('admin.pages.create');
	}

	/**
	 * Save created page
	 * @param Request $request 
	 * @return type
	 */
	public function postSave(Request $request)
	{
		
	}
}