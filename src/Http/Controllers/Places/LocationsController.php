<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\Map;
use SystemInc\LaravelAdmin\Location;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\LocationValidation;
use Validator;

class LocationsController extends Controller
{
    use HelpersTrait;

    public function __construct()
    {
        if (config('laravel-admin.modules.places') == false) {
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
        $maps = Map::all();

        return view('admin::locations.create', compact('maps'));
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

        $location->image = $this->saveImage($request->file('image'), 'locations');
        $location->thumb_image = $this->saveImage($request->file('thumb_image'), 'locations/thumb');
        $location->marker_image = $this->saveImage($request->file('marker_image'), 'locations/marker');
        
        if ($request->map_id == 0) {
            $location->map_id = null;
        }

        $location->key = $this->sanitizeUri($request->key);
        $location->save();

        return redirect(config('laravel-admin.route_prefix').'/places/locations')->with('success', 'Saved successfully');
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

        $maps = Map::all();

        return view('admin::locations.edit', compact('location', 'maps'));
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
        $validation = Validator::make($data, LocationValidation::rules($location_id), LocationValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $location = Location::find($location_id);
        $location->fill($data);

        $location->image = $this->saveImage($request->file('image'), 'locations');
        $location->thumb_image = $this->saveImage($request->file('thumb_image'), 'locations/thumb');
        $location->marker_image = $this->saveImage($request->file('marker_image'), 'locations/marker');
       
        if ($request->map_id == 0) {
            $location->map_id = null;
        }

        $location->key = $this->sanitizeUri($request->key);

        if ($request->input('delete_image')) {
            if (Storage::exists($location->image)) {
                Storage::delete($location->image);
            }
            $location->image = null;
        }

        if ($request->input('delete_thumb_image')) {
            if (Storage::exists($location->thumb_image)) {
                Storage::delete($location->thumb_image);
            }
            $location->thumb_image = null;
        }

        if ($request->input('delete_marker_image')) {
            if (Storage::exists($location->marker_image)) {
                Storage::delete($location->marker_image);
            }
            $location->marker_image = null;
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

        if (!empty($location->thumb_image)) {
            Storage::delete($location->thumb_image);
        }

        if (!empty($location->marker_image)) {
            Storage::delete($location->marker_image);
        }

        $location->delete();

        return redirect(config('laravel-admin.route_prefix').'/places/locations')->with('success', 'Deleted successfully');
    }
}
