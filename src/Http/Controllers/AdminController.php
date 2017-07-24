<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Image;
use Response;
use Storage;
use SystemInc\LaravelAdmin\Admin;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class AdminController extends Controller
{
    use HelpersTrait;

    /**
     * Index admin page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('admin::index');
    }

    /**
     *	Show form for login admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        if (Auth::guard('system-admin')->check()) {
            return redirect(config('laravel-admin.route_prefix'));
        } else {
            return view('admin::login');
        }
    }

    /**
     * Admin login.
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        if (Auth::guard('system-admin')->check() || Auth::guard('system-admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect(config('laravel-admin.route_prefix'));
        } else {
            return back()->with(['message' => 'Login failed']);
        }
    }

    /**
     * Logout admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::guard('system-admin')->logout();

        return redirect(config('laravel-admin.route_prefix').'/login');
    }

    /**
     * Store a tiny image in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function anyTinyImages(Request $request)
    {
        $page_id = $request->get('page_id');
        $page_name = $request->get('page_name');
        $editor_id = $request->get('editor_id');

        $directory = 'images/tiny/'.$page_name.'/'.$page_id;

        if (!Storage::exists('public/'.$directory)) {
            Storage::createDir('public/'.$directory);
        }
        $images = Storage::files('public/'.$directory);

        return view('admin::tiny-images', compact('page_id', 'page_name', 'editor_id', 'images', 'directory'));
    }

    /**
     * Upload a tiny image in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function anyUploadTinyImage(Request $request)
    {
        $directory = $request->get('directory');

        $allowed = ['jpg', 'jpeg', 'gif', 'png'];

        foreach ($request->file('files') as $file) {
            if ($file->isValid() && in_array($file->getClientOriginalExtension(), $allowed) && strpos($directory, 'images/tiny') !== false) {
                $original = $this->cleanSpecialChars($file->getClientOriginalName());

                $original_image = Image::make($file)->encode();

                Storage::put('public/'.$directory.'/'.$original, $original_image);
            }
        }

        return back();
    }

    /**
     * Delete a tiny image from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postDeleteTinyImage(Request $request)
    {
        $path = $request->get('path');

        if (Storage::exists($path) && strpos($path, 'images/tiny') !== false) {
            Storage::delete($path);
        }

        return Response::json(true);
    }
}
