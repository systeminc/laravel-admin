<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use View;
use File;

class LayoutsController extends Controller
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
     * Layouts controller index page.
     *
     * @return type
     */
    public function getIndex()
    {
        $templates = Storage::disk('system-images')->allFiles('templates');

        return view('admin.layouts.index', compact('templates'));
    }

    /**
     * Create new layouts.
     *
     * @return type
     */
    public function getCreate()
    {
        return view('admin.layouts.create');
    }

    /**
     * Save created layout.
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

        Storage::disk('system')->put('/layouts/' . $request->title . '.blade.php', 'test');
    }

    public function getEdit($template_id)
    {
        $templates = Storage::disk('system-images')->files('templates');
        $template = $templates[$template_id];

        $filename = File::name($template);

        $snippet = Storage::disk('system')->get('/layouts/' . $filename . '.blade.php');
        
        return view('admin.layouts.edit', compact('template', 'snippet', 'filename'));
    }

    public function postUpdate(Request $request, $template_name)
    {        
        //RENAME FILE
        if ($template_name !== $request->title) {
            Storage::disk('system')
                    ->move('/layouts/' . $template_name . '.blade.php', '/layouts/' . $request->title . '.blade.php');
            Storage::disk('system-images')
                    ->move($request->image, '/templates/' . $request->title . '.' . File::extension($request->image));
        }

        Storage::disk('system')->put('/layouts/' . $request->title . '.blade.php', $request->html_layout);

        return back();
    }
}