<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $pages = Storage::disk('system')->allFiles('system');

        return view('admin::pages.index', compact('pages'));
    }

    /**
     * Create new pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $templates = ['#TODO'];

        return view('admin::pages.create', compact('templates'));
    }

    /**
     * Save created page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
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

    /**
     * Edit page.
     *
     * @param string $filename
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($filename)
    {
        $snippet = Storage::disk('system')->get('/system/'.$filename.'.blade.php');

        return view('admin::pages.edit', compact('snippet', 'filename'));
    }

    /**
     * Update page.
     *
     * @param Request $request
     * @param string  $filename
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $filename)
    {
        //RENAME FILE
        if ($filename !== $request->title) {
            Storage::disk('system')
                    ->move('/system/'.$filename.'.blade.php', '/system/'.$request->title.'.blade.php');
        }
        Storage::disk('system')->put('/system/'.$request->title.'.blade.php', $request->html_layout);

        return redirect('administration/pages/edit/'.$request->title);
    }

    /**
     * Preview page.
     *
     * @param string $filename
     *
     * @return \Illuminate\Http\Response
     */
    public function getPreview($filename)
    {
        $snippet = Storage::disk('system')->get('/system/'.$filename.'.blade.php');

        return view('admin::pages.preview', compact('snippet', 'filename'));
    }

    /**
     * Delete page.
     *
     * @param string $filename
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($filename)
    {
        Storage::disk('system')->delete('/system/'.$filename.'.blade.php');

        return redirect('administration/pages');
    }
}
