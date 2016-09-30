<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Location;
use SystemInc\LaravelAdmin\LocationMarker;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\LocationMarkerValidation;
use SystemInc\LaravelAdmin\Validations\LocationValidation;
use Validator;

class LocationsController extends Controller
{
    use HelpersTrait;

    public function __construct()
    {
        if (config('laravel-admin.modules.locations') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
    }

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

        foreach (LocationMarker::whereLocationId($location_id)->get() as $marker) {
            $marker->delete();
        }

        $location->delete();

        return redirect(config('laravel-admin.route_prefix').'/locations')->with('success', 'Deleted successfully');
    }

    /**
     * Add map marker.
     *
     * @param int $location_id
     *
     * @return type
     */
    public function getAddMarker($location_id)
    {
        $location = Location::find($location_id);

        return view('admin::locations.add_marker', compact('location'));
    }

    /**
     * Save map marker.
     *
     * @param Request $request
     * @param int     $location_id
     *
     * @return type
     */
    public function postSaveMarker(Request $request, $location_id)
    {
        // validation
        $validation = Validator::make($request->all(), LocationMarkerValidation::rules(), LocationMarkerValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        LocationMarker::create([
            'title'         => $request->title,
            'key'           => $this->sanitizeUri($request->key),
            'location_id'   => $location_id,
            'description'   => $request->description,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
        ]);

        return redirect(config('laravel-admin.route_prefix').'/locations/edit/'.$location_id)->with('success', 'Map marker is created');
    }

    /**
     * Edit map marker.
     *
     * @param int $marker_id
     *
     * @return type
     */
    public function getEditMarker($marker_id)
    {
        $marker = LocationMarker::find($marker_id);

        return view('admin::locations.edit_marker', compact('marker'));
    }

    /**
     * Update map marker.
     *
     * @param Request $request
     * @param int     $marker_id
     *
     * @return type
     */
    public function postUpdateMarker(Request $request, $marker_id)
    {
        // validation
        $validation = Validator::make($request->all(), LocationMarkerValidation::rules($marker_id), LocationMarkerValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        LocationMarker::find($marker_id)->update([
            'title'         => $request->title,
            'key'           => $this->sanitizeUri($request->key),
            'description'   => $request->description,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
        ]);

        return redirect(config('laravel-admin.route_prefix').'/locations/edit/'.$marker_id)->with('success', 'Map marker is updated');
    }

    /**
     * Delete map marker.
     *
     * @param int $marker_id
     *
     * @return type
     */
    public function getDeleteMarker($marker_id)
    {
        $marker = LocationMarker::find($marker_id);

        $redirect_id = $marker->location_id;

        $marker->delete();

        return redirect(config('laravel-admin.route_prefix').'/locations/edit/'.$redirect_id)->with('success', 'Map marker is deleted');
    }
}
