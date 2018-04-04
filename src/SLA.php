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
            return Page::where(['slug' => $page_query])->with('elements')->first();
        } elseif (is_int($page_query)) {
            return Page::where(['id' => $page_query])->with('elements')->first();
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
            return Gallery::where(['key' => $key])->with('images')->first();
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
     * @return Map
     */
    public function map($key)
    {
        return Map::where(['key' => $key])->first();
    }

    /**
     * Get file from storage.
     *
     * @param string $key
     *
     * @return string
     */
    public function getFile($key)
    {
        return Storage::exists($key) ? Storage::url($key) : false;
    }

    /**
     * Get image from storage. Optionally resized and cached for future use.
     *
     * @param string   $key
     * @param null|int $width
     * @param null|int $height
     *
     * @return string
     */
    public function getImage($key, $width = null, $height = null)
    {
        if (!Storage::exists($key)) {
            return false;
        }

        if ($width || $height) {
            list($dirname, $basename, $extension, $filename) = array_values(pathinfo($key));

            if ($extension === 'svg') {
                return Storage::url($key);
            }

            $width_modifier = empty($width) ? '' : "_w$width";
            $height_modifier = empty($height) ? '' : "_h$height";

            $resized_key = $dirname.DIRECTORY_SEPARATOR.$filename.$width_modifier.$height_modifier.'.'.$extension;

            if (Storage::exists($resized_key)) {
                return Storage::url($resized_key);
            } else {
                $image = Image::make(Storage::get($key))
                    ->orientate()
                    ->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->interlace()
                    ->encode();

                Storage::put($resized_key, $image);

                return Storage::url($resized_key);
            }
        }

        return Storage::url($key);
    }
}
