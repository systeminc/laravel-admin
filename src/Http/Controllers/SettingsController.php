<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\Admin;
use SystemInc\LaravelAdmin\Setting;
use SystemInc\LaravelAdmin\Validations\AdminValidation;
use SystemInc\LaravelAdmin\Validations\AdminValidationWithoutPassword;

class SettingsController extends Controller
{
    public function __construct()
    {
        if (config('laravel-admin.modules.settings') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'Settings module is disabled in config/laravel-admin.php')->send();
        }
    }

    /**
     * Layouts controller index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $admins = Admin::all();

        $setting = Setting::first();

        return view('admin::settings.index', compact('admins', 'setting'));
    }

    /**
     * Update admin panel.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request)
    {
        $data = [];
        $data['title'] = !empty($request->title) ? $request->title : null;

        $file = $request->file('logo');

        if ($file && $file->isValid()) {
            $file_path = 'admin-panel/'.$file->getClientOriginalName();

            Storage::deleteDirectory('admin-panel');
            Storage::put($file_path, file_get_contents($file));

            $data['source'] = $file_path;
        }

        $setting = Setting::first();

        !empty($setting->id) ? $setting->update($data) : Setting::create($data);

        return back();
    }

    /**
     * Edit admin.
     *
     * @param int $admin_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($admin_id)
    {
        $admin = Admin::find($admin_id);

        return view('admin::settings.edit', compact('admin'));
    }

    /**
     *  Change admin password.
     *
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request, $admin_id)
    {
        $admin = Admin::find($admin_id);

        if (Hash::check($request->old_pass, $admin->password)) {
            if ($request->new_pass === $request->confirm_pass) {
                $admin->password = Hash::make($request->new_pass);

                $admin->save();

                return back()->with(['success' => 'Password changed']);
            } else {
                return back()->with(['pass' => 'Wrong repeat password']);
            }
        } else {
            return back()->with(['pass' => 'Wrong old password']);
        }
    }

    /**
     * Update admin.
     *
     * @param Request $request
     * @param int     $admin_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdateAdmin(Request $request, $admin_id)
    {
        $validation = Validator::make($request->all(), AdminValidationWithoutPassword::rules($admin_id), AdminValidationWithoutPassword::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $admin = Admin::find($admin_id);

        $admin->name = $request->name;
        $admin->email = $request->email;

        $admin->save();

        return back();
    }

    /**
     * Add admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAddAdmin()
    {
        return view('admin::settings.create');
    }

    /**
     * Save admin.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreateAdmin(Request $request)
    {
        // validation
        $validation = Validator::make($request->all(), AdminValidation::rules(), AdminValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect($request->segment(1).'/settings');
    }
}
