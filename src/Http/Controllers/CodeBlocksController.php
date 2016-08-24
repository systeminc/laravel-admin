<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use View;

class CodeBlocksController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $code_blocks = Storage::disk('system')->allFiles('code-blocks');

        return view('admin::code-blocks.index', compact('code_blocks'));
    }

    /**
     * Create new code-blocks.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('admin::code-blocks.create');
    }

    /**
     * Save created layout.
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
        Storage::disk('system')->put('/code-blocks/'.$request->title.'.blade.php', $request->html_layout);

        return redirect(config('laravel-admin.route_prefix').'/code-blocks');
    }

    /**
     * Edit layout.
     *
     * @param string $template_name
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($template_name)
    {
        $snippet = Storage::disk('system')->get('/code-blocks/'.$template_name.'.blade.php');

        return view('admin::code-blocks.edit', compact('snippet', 'template_name'));
    }

    /**
     * Update layout.
     *
     * @param Request $request
     * @param string  $template_name
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $template_name)
    {
        //RENAME FILE
        if ($template_name !== $request->title) {
            Storage::disk('system')
                    ->move('/code-blocks/'.$template_name.'.blade.php', '/code-blocks/'.$request->title.'.blade.php');
        }
        Storage::disk('system')->put('/code-blocks/'.$request->title.'.blade.php', $request->html_layout);

        return redirect(config('laravel-admin.route_prefix').'/code-blocks/edit/'.$request->title);
    }

    /**
     * Preview layout.
     *
     * @param string $template_name
     *
     * @return \Illuminate\Http\Response
     */
    public function getPreview($template_name)
    {
        $snippet = Storage::disk('system')->get('/code-blocks/'.$template_name.'.blade.php');

        return view('admin::code-blocks.preview', compact('snippet', 'template_name'));
    }

    /**
     * Delete layout.
     *
     * @param string $template_name
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($template_name)
    {
        $snippet = Storage::disk('system')->delete('/code-blocks/'.$template_name.'.blade.php');

        return redirect(config('laravel-admin.route_prefix').'/code-blocks');
    }
}
