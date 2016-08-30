<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryImage;

class GalleriesController extends Controller
{
    /**
     * Show all galleries.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $galleries = Gallery::all();

        return view('admin::galleries.index', compact('galleries'));
    }

    /**
     * Create gallery.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('admin::galleries.create');
    }

    /**
     * Save gallery.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {
        if (!empty($request->title) || $request->hasFile('images')) {
            $gallery = Gallery::create([
                'title' => $request->title,
            ]);

            return redirect(config('laravel-admin.route_prefix').'/galleries');
        } else {
            return back()->with('error', 'Title is required');
        }
    }

    /**
     * Edit gallery.
     *
     * @param string $gallery_title
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($gallery_title)
    {
        $gallery = Gallery::whereTitle($gallery_title)->first();
        $images = $gallery->images;

        return view('admin::galleries.edit', compact('gallery', 'images'));
    }

    /**
     * Update gallery.
     *
     * @param Request $request
     * @param string  $gallery_title
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $gallery_title)
    {
        $gallery = Gallery::whereTitle($gallery_title)->first();

        if ($request->title == $gallery_title) {
            $this->Images($request->file('images'), $gallery->id);
        } elseif (!empty($request->title)) {
            $gallery->title = $request->title;
            $gallery->save();

            $this->Images($request->file('images'), $gallery->id);
        }

        return back();
    }

    /**
     * Delete gallery and all image.
     *
     * @param string $gallery_title
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($gallery_title)
    {
        $gallery = Gallery::whereTitle($gallery_title)->first();

        if ($gallery->product_id) {
            return redirect(config('laravel-admin.route_prefix').'/galleries/edit/'.$gallery_title)->with('message', 'This gallery is in the use');
        }

        foreach ($gallery->images as $image) {
            Storage::delete($image->source, $image->thumb_source, $image->mobile_source);

            $image->delete();
        }
        $gallery->delete();

        return redirect(config('laravel-admin.route_prefix').'/galleries');
    }

    /**
     * Store a created images in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function Images($images, $gallery_id)
    {
        if (is_array($images)) {
            foreach (array_filter($images) as $image) {
                if ($image->isValid()) {
                    $image_name = str_random(5);

                    $original = '/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();
                    $thumb = '/thumb/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();
                    $mobile = '/mobile/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();

                    $original_url = 'images/galleries'.$original;
                    $thumb_url = 'images/galleries'.$thumb;
                    $mobile_url = 'images/galleries'.$mobile;

                    $original_path = storage_path($original_url);

                    if (!File::isDirectory(storage_path('images/galleries/thumb/'))) {
                        File::makeDirectory(storage_path('images/galleries/thumb/'), 493, true);
                    }

                    if (!File::isDirectory(storage_path('images/galleries/mobile/'))) {
                        File::makeDirectory(storage_path('images/galleries/mobile/'), 493, true);
                    }

                    $original_image = Image::make($image)
                        ->fit(1920, 1080, function ($constraint) {
                            $constraint->upsize();
                        })->encode();
                    Storage::put($original_url, $original_image);

                    $thumb_image = Image::make($image)
                        ->fit(375, 200, function ($constraint) {
                            $constraint->upsize();
                        })->encode();
                    Storage::put($thumb_url, $thumb_image);

                    $mobile_image = Image::make($image)
                        ->fit(1024, 768, function ($constraint) {
                            $constraint->upsize();
                        })->encode();
                    Storage::put($mobile_url, $mobile_image);
                }

                GalleryImage::create([
                    'gallery_id'        => $gallery_id,
                    'source'            => $original_url,
                    'path_source'       => $original_path,
                    'thumb_source'      => $thumb_url,
                    'mobile_source'     => $mobile_url,
                ]);
            }

            return true;
        }
    }
}
