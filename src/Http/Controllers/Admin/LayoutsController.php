<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use File;
use Image;
use Illuminate\Http\Request;
use Storage;
use View;

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
        $snippet = Storage::disk('system')->get('/snippet/snippet.blade.php');

        return view('admin.layouts.create', compact('snippet'));
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
        // $img = Image::make('<iframe>'.$request->html_layout.'</iframe>');
        // $img->save(public_path('images/'.$request->title.'.png'));
        // Storage::disk('system')->put('/layouts/'.$request->title.'.blade.php', $request->html_layout);

        return back();
    }

    public function getEdit($template_id)
    {
        $templates = Storage::disk('system-images')->files('templates');
        $template = $templates[$template_id];

        $filename = File::name($template);

        $snippet = Storage::disk('system')->get('/layouts/'.$filename.'.blade.php');

        return view('admin.layouts.edit', compact('template', 'snippet', 'filename'));
    }

    public function postUpdate(Request $request, $template_name)
    {
        //RENAME FILE
        if ($template_name !== $request->title) {
            Storage::disk('system')
                    ->move('/layouts/'.$template_name.'.blade.php', '/layouts/'.$request->title.'.blade.php');
            Storage::disk('system-images')
                    ->move($request->image, '/templates/'.$request->title.'.'.File::extension($request->image));
        }

        Storage::disk('system')->put('/layouts/'.$request->title.'.blade.php', $request->html_layout);

        return back();
    }
}
