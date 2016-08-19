<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryImage;
use View;

class GalleriesController extends Controller
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
            $this->Images($request->file('images'), $gallery->id);

            return redirect('administration/galleries');
        } else {
            return back();
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

        foreach ($gallery->images as $image) {
            File::delete($image->source, $image->thumb_source, $image->mobile_source);

            $image->delete();
        }
        $gallery->delete();

        return redirect('administration/galleries');
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

                    if (!File::isDirectory('images/galleries/thumb')) {
                        File::makeDirectory('images/galleries/thumb', 493, true);
                    }

                    if (!File::isDirectory('images/galleries/mobile')) {
                        File::makeDirectory('images/galleries/mobile', 493, true);
                    }

                    $original_path = public_path($original_url);
                    $thumb_path = public_path($thumb_url);
                    $mobile_path = public_path($mobile_url);

                    $original_resized = Image::make($image)
                        ->fit(1920, 1080, function ($constraint) {
                            $constraint->upsize();
                        })->save($original_path);

                    $thumb_resized = Image::make($image)
                        ->fit(375, 200, function ($constraint) {
                            $constraint->upsize();
                        })->save($thumb_path);

                    $mobile_resized = Image::make($image)
                        ->fit(1024, 768, function ($constraint) {
                            $constraint->upsize();
                        })->save($mobile_path);
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
