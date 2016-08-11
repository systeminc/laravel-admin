<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
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
     * @return type
     */
    public function getIndex()
    {
        $pages = Storage::disk('system')->allFiles('system');

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Create new pages.
     *
     * @return type
     */
    public function getCreate()
    {
        $templates = Storage::disk('system-images')->allFiles('templates');

        return view('admin.pages.create', compact('templates'));
    }

    /**
     * Save created page.
     *
     * @param Request $request
     *
     * @return type
     */
    public function postSave(Request $request)
    {
        if (empty($request->title)) {
            return back()->withErrors(['message' => 'Title is required']);
        }

        $extend_layout = "@extends('layouts.$request->template')\xA@section('content')\xA\xAYour code goes here\xA\xA@stop";
        Storage::disk('system')->put('/system/'.$request->title.'.blade.php', $extend_layout);

        return redirect('administration/pages/edit/'.$request->title);
    }

    public function getEdit($filename)
    {
        $snippet = Storage::disk('system')->get('/system/'.$filename.'.blade.php');

        return view('admin.pages.edit', compact('snippet', 'filename'));
    }
}