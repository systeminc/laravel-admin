<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;
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
        return view('admin.index');
    }

    /**
     *	Show form for login admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        dd(config('admin.auth'));
        if (Auth::guard('system-admin')->check()) {
            return redirect('administration');
        } else {
            return view('admin.login');
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
            return redirect('administration');
        } else {
            return back()->with(['message' => 'Login failed']);
        }
    }

    /**
     * Change password form.
     * */
    public function getChangePassword()
    {
        return view('admin.change_password');
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

        return redirect('administration');
    }

    /**
     * Logout admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::guard('system-admin')->logout();

        return redirect('administration/login');
    }
}
