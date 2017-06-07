<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryImage;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class GalleriesController extends Controller
{
    use HelpersTrait;

    public function __construct()
    {
        if (config('laravel-admin.modules.galleries') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
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
            $key = $this->sanitizeElements($request->title);

            if (Gallery::where(['key' => $key])->first()) {
                return back()->with(['error' => 'Similar gallery exists, so we can create key('.$key.'), try deferent title']);
            }

            $gallery = Gallery::create([
                'title' => $request->title,
                'key'   => $key,
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
    public function getEdit($gallery_id)
    {
        $gallery = Gallery::find($gallery_id);

        return view('admin::galleries.edit', compact('gallery'));
    }

    /**
     * Update gallery.
     *
     * @param Request $request
     * @param string  $gallery_title
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $gallery_id)
    {
        $gallery = Gallery::find($gallery_id);

        if ($gallery->key !== $request->key && Gallery::where(['key' => $request->key])->first()) {
            return back()->with(['error' => 'This key exists']);
        }

        $this->uploadImages($request->file('images'), $gallery->id);

        $gallery->title = !empty($request->title) ? $request->title : $gallery->title;
        $gallery->key = $this->sanitizeElements($request->key);
        $gallery->save();

        return back();
    }

    /**
     * Delete gallery and all image.
     *
     * @param string $gallery_title
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete($gallery_id)
    {
        $gallery = Gallery::find($gallery_id);

        if ($gallery->product_id) {
            return redirect(config('laravel-admin.route_prefix').'/galleries/edit/'.$gallery_id)->with('message', 'This gallery is in the use');
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
    private function uploadImages($images, $gallery_id)
    {
        if (is_array($images)) {
            foreach (array_filter($images) as $image) {
                if ($image->isValid()) {
                    $image_name = str_random(5);

                    $original = '/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();
                    $thumb = '/thumb/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();
                    $mobile = '/mobile/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();

                    $original_path = storage_path('images/galleries'.$original);

                    $original_image = $this->resizeImage(1920, 1080, 'images/galleries/', 'images/galleries'.$original, $image);
                    $thumb_image = $this->resizeImage(375, 200, 'images/galleries/thumb/', 'images/galleries'.$thumb, $image);
                    $mobile_image = $this->resizeImage(1024, 768, 'images/galleries/mobile/', 'images/galleries'.$mobile, $image);
                }

                GalleryImage::create([
                    'gallery_id'        => $gallery_id,
                    'source'            => $original_image,
                    'path_source'       => $original_path,
                    'thumb_source'      => $thumb_image,
                    'mobile_source'     => $mobile_image,
                ]);
            }

            return true;
        }
    }
}
