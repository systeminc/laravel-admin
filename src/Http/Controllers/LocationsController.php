<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Location;
use SystemInc\LaravelAdmin\Validations\LocationValidation;
use Validator;

class LocationsController extends Controller
{
    /**
     * Show all locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $locations = Location::all();

        return view('admin::locations.index', compact('locations'));
    }

    /**
     * Create Location.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('admin::locations.create');
    }

    /**
     * Save Location.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {
        $data = $request->all();

        // validation
        $validation = Validator::make($data, LocationValidation::rules(), LocationValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $location = new Location();
        $location->fill($data);

        $image = $request->file('image');

        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $dirname = 'images/locations'.$original;

            $original_image = Image::make($image)
                ->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                })->encode();

            Storage::put($dirname, $original_image);

            $location->image = $dirname;
        }
        $location->save();

        return redirect(config('laravel-admin.route_prefix').'/locations')->with('success', 'Saved successfully');
    }

    /**
     * Edit Location.
     *
     * @param string $location_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($location_id)
    {
        $location = Location::find($location_id);

        return view('admin::locations.edit', compact('location'));
    }

    /**
     * Update Location.
     *
     * @param Request $request
     * @param string  $location_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $location_id)
    {
        $data = $request->all();

        // validation
        $validation = Validator::make($data, LocationValidation::rules(), LocationValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $location = Location::find($location_id);
        $location->fill($data);

        $image = $request->file('image');

        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $dirname = 'images/locations'.$original;

            $original_image = Image::make($image)
                ->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                })->encode();

            Storage::put($dirname, $original_image);

            $location->image = $dirname;
        }

        if ($request->input('delete_image')) {
            if (Storage::exists($location->image)) {
                Storage::delete($location->image);
            }
            $location->image = null;
        }
        $location->save();

        return back()->with('success', 'Saved successfully');
    }

    /**
     * Delete Location and all image.
     *
     * @param string $location_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($location_id)
    {
        $location = Location::find($location_id);

        if (!empty($location->image)) {
            Storage::delete($location->image);
        }

        $location->delete();

        return redirect(config('laravel-admin.route_prefix').'/locations')->with('success', 'Deleted successfully');
    }
}
