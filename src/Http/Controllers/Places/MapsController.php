<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Places;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SystemInc\LaravelAdmin\Map;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\MapValidation;
use Validator;

class MapsController extends Controller
{
    use HelpersTrait;

    public function __construct()
    {
        if (config('laravel-admin.modules.places') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
    }

    /**
     * Show all maps.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $maps = Map::all();

        return view('admin::maps.index', compact('maps'));
    }

    /**
     * Create Map.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('admin::maps.create');
    }

    /**
     * Save Map.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {
        $data = $request->all();

        // validation
        $validation = Validator::make($data, MapValidation::rules(), MapValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $map = new Map();
        $map->fill($data);

        $map->key = $this->sanitizeUri($request->key);
        $map->save();

        return redirect(config('laravel-admin.route_prefix').'/places/maps')->with('success', 'Saved successfully');
    }

    /**
     * Edit Map.
     *
     * @param string $map_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($map_id)
    {
        $map = Map::find($map_id);

        return view('admin::maps.edit', compact('map'));
    }

    /**
     * Update Map.
     *
     * @param Request $request
     * @param string  $map_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $map_id)
    {
        $data = $request->all();

        // validation
        $validation = Validator::make($data, MapValidation::rules($map_id), MapValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $map = Map::find($map_id);
        $map->fill($data);

        $map->key = $this->sanitizeUri($request->key);
        $map->save();

        return back()->with('success', 'Saved successfully');
    }

    /**
     * Delete Map and all image.
     *
     * @param string $map_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($map_id)
    {
        $map = Map::find($map_id)->delete();

        return redirect(config('laravel-admin.route_prefix').'/places/maps')->with('success', 'Deleted successfully');
    }
}
