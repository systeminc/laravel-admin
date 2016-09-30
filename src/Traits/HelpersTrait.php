<?php

namespace SystemInc\LaravelAdmin\Traits;

use Image;
use Storage;

trait HelpersTrait
{
    public function sanitizeUri($uri)
    {
        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-\/]/', '/\/+/', '/-+/'], ['', '/', '-'], $uri)), '/-');
    }

    public function sanitizeUriKey($uri_key)
    {
        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-]/', '/-+/'], ['', '-'], $uri_key)), '-');
    }

    public function sanitizeElements($element)
    {
        return trim(strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $element)), '_');
    }

    public function generateNestedPageList($pages, $navigation = '')
    {
        $navigation .= '<ul>';

        foreach ($pages as $page) {
            $navigation .= '<li>';
            $navigation .= '<a href="pages/edit/'.$page->id.'"><b>'.$page->title.'</a>';

            if ($page->subpages()->count()) {
                $navigation = $this->generateNestedPageList($page->subpages(), $navigation);
            }

            $navigation .= '</li>';
        }

        $navigation .= '</ul>';

        return $navigation;
    }

    public function saveImage($image, $path)
    {
        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $storage_key = 'images/'.$path.$original;

            $original_image = Image::make($image)
                ->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                })->encode();

            Storage::put($storage_key, $original_image);

            return $storage_key;
        }

        return null;
    }
}
