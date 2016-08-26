<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SystemInc\LaravelAdmin\Page;
use SystemInc\LaravelAdmin\Validations\PageValidation;
use Validator;
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
        $pages = Page::all();

        return view('admin::pages.index', compact('pages'));
    }

    public function getCreate()
    {
        return view('admin::pages.create');
    }

    public function postSave(Request $request)
    {
        $data = $request->all();
        
        // validation
        $validation = Validator::make($data, PageValidation::rules(), PageValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }
        $page = Page::create($data);

        return redirect($request->segment(1).'/pages/edit/'.$page->id);
    }

    public function postUpdate(Request $request, $page_id)
    {
        $data = $request->all();
        
        // validation
        $validation = Validator::make($data, PageValidation::rules(), PageValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }
        $page = Page::find($page_id)->update($data);

        return back();        
    }

    public function getEdit($page_id)
    {
        $page = Page::find($page_id);

        return view('admin::pages.edit', compact('page'));
    }

    public function getDelete(Request $request, $page_id)
    {
        Page::find($page_id)->delete();

        return redirect($request->segment(1).'/pages');
    }
}
