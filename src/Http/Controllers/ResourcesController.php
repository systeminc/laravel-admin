<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use File;
use Image;

class ResourcesController extends Controller
{
    private $css_path;
    private $js_path;
    private $image_path;

    public function __construct()
    {
        $this->css_path = base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/css/');
        $this->js_path = base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/js/');
        $this->image_path = base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/images/');
    }

    /**
     * Get css.
     *
     * @param file $filename
     *
     * @return response
     */
    public function css($filename)
    {
        return response()->file($this->css_path.$filename, ['Content-Type' => 'text/css']);
    }

    /**
     * Get script.
     *
     * @param file $filename
     *
     * @return response
     */
    public function scripts($filename)
    {
        if (File::extension($this->js_path.$filename)) {
            $mime = 'text/css';
        } else {
            $mime = File::mimeType($this->js_path.$filename);
        }

        return response()->file($this->js_path.$filename, ['Content-Type' => $mime]);
    }

    /**
     * Get image.
     *
     * @param file $filename
     *
     * @return response
     */
    public function images($filename)
    {
        $src = $this->image_path.$filename;

        $cache_image = Image::cache(function($image) use($src) {
            return $image->make($src)->greyscale();
        }, 60);

        return response()->make($cache_image, 200);
    }
}
