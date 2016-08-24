<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Admin;
use View;

class AdminController extends Controller
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
     * Change password form.
     * */
    public function getChangePassword()
    {
        return view('admin::change_password');
    }

    /**
     *	Change admin password.
     *
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request)
    {
        $admin = Admin::find(Auth::guard('system-admin')->user()->id);

        if (Hash::check($request->old_pass, $admin->password)) {
            if ($request->new_pass === $request->confirm_pass) {
                $admin->password = Hash::make($request->new_pass);

                $admin->save();
            }
        }

        return redirect(config('laravel-admin.route_prefix'));
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

        // $page_name = 'test';
        $page_name = $request->get('page_name');

        $editor_id = $request->get('editor_id');

        $directory = 'images/tiny/'.$page_name.'/'.$page_id;

        if (!Storage::exists($directory)) {
            Storage::createDir($directory);
        }

        View::share('page_id', $page_id);

        View::share('page_name', $page_name);

        View::share('editor_id', $editor_id);

        View::share('images', Storage::files($directory));

        View::share('directory', $directory);

        return view('admin::tiny-images');
    }

    /**
     * Upload Tiny Image.
     * */
    public function anyUploadTinyImage(Request $request)
    {
        $directory = $request->get('directory');

        $allowed = ['jpg', 'jpeg', 'gif', 'png'];

        foreach ($request->file('files') as $file) {
            if ($file->isValid() && in_array($file->getClientOriginalExtension(), $allowed) && strpos($directory, 'images/tiny') !== false) {
                $original = $file->getClientOriginalName();

                $original_image = Image::make($file)->encode();

                Storage::put($directory.'/'.$original, $original_image);
            }
        }

        return back();
    }

    /**
     * Delete Tiny Image.
     * */
    public function postDeleteTinyImage(Request $request)
    {
        $path = $request->get('path');

        if (Storage::exists($path) && strpos($path, 'images/tiny') !== false) {
            Storage::delete($path);
        }

        return Response::json(true);
    }
}
