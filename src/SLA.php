<?php

namespace SystemInc\LaravelAdmin;

use Image;
use Storage;

class SLA
{
    /**
     * Instance of Blog.
     *
     * @return type
     */
    public function blog()
    {
        return new Blog();
    }

    /**
     * Instance of Shop.
     *
     * @return type
     */
    public function shop()
    {
        return new Shop();
    }

    /**
     * Instance of Page.
     *
     * @return type
     */
    public function page($page_query = null)
    {
        if (is_string($page_query)) {
            return Page::where(['slug' => $page_query])->first();
        } elseif (is_int($page_query)) {
            return Page::where(['id' => $page_query])->first();
        }

        return new Page();
    }

    /**
     * Get page element.
     *
     * @param string $key
     *
     * @return type
     */
    public function element($key)
    {
        return PageElement::where(['key' => $key])->first();
    }

    /**
     * Instance of Gallery.
     *
     * @return type
     */
    public function gallery($key = false)
    {
        if ($key) {
            return Gallery::where(['key' => $key])->first();
        }

        return new Gallery();
    }

    /**
     * Instance of Subscribe.
     *
     * @return type
     */
    public function lead()
    {
        return new Subscribe();
    }

    /**
     * Instance of Location.
     *
     * @return type
     */
    public function locations()
    {
        return Location::all();
    }

    /**
     * Instance of Location.
     *
     * @return type
     */
    public function location($key)
    {
        return Location::where(['key' => $key])->first();
    }

    /**
     * Instance of map.
     *
     * @return type
     */
    public function maps()
    {
        return Map::all();
    }

    /**
     * Instance of map.
     *
     * @return type
     */
    public function map($key)
    {
        return Map::where(['key' => $key])->first();
    }

    /**
     * Get file from storage(Image, PDF,...).
     *
     * @param string      $filename
     * @param bool|number $width
     * @param bool|number $height
     *
     * @return string
     */
    public function getFile($path, $width = null, $height = null)
    {
        if (!Storage::exists($path)) {
            return false;
        } 

        if ($width || $height) {
            list($dirname, $basename, $extension, $filename) = array_values(pathinfo($path));

            $width_modifier = empty($width) ? '' : "_$width";
            $height_modifier = empty($height) ? '' : "_$height";

            $new_path = $dirname . DIRECTORY_SEPARATOR . $filename . $width_modifier . $height_modifier . '.' . $extension;

            if (Storage::exists($new_path)) {
                return Storage::url($new_path);
            } 
            else {
                $image = Image::make(Storage::get($path))
                    ->orientate()
                    ->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->interlace()
                    ->encode();

                Storage::put($new_path, $image);

                return Storage::url($new_path);
            }
        }

        return Storage::url($path);
    }
}
