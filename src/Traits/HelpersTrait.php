<?php

namespace SystemInc\LaravelAdmin\Traits;

use Image;
use Storage;

trait HelpersTrait
{
    /**
     * Sanitize elements.
     */
    protected function sanitizeElements($element)
    {
        return trim(strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $element)), '_');
    }

    /**
     * Generate nasted page list.
     */
    protected function generateNestedPageList($pages, $navigation = '')
    {
        $navigation .= '<ul class="border">';

        foreach ($pages as $page) {
            $navigation .= '<li>';
            $navigation .= '<a href="pages/edit/'.$page->id.'">'.$page->title.'</a>';

            if ($page->subpages()->count()) {
                $navigation = $this->generateNestedPageList($page->subpages(), $navigation);
            }

            $navigation .= '</li>';
        }

        $navigation .= '</ul>';

        return $navigation;
    }

    /**
     * Save image.
     */
    protected function saveImage($image, $path)
    {
        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $storage_key = 'images/'.$path.$original;

            $original_image = Image::make($image)->orientate()
                ->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                })->encode();

            Storage::put($storage_key, $original_image);

            return $storage_key;
        }
        return false;
    }

    /**
     * Handle image upload and resize.
     */
    protected function resizeImage($width, $height, $path, $output_path, $image)
    {
        if (!Storage::isDirectory($path)) {
            Storage::makeDirectory($path, 493, true);
        }

        $image = Image::make($image)->orientate()
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode();
        Storage::put($output_path, $image);

        return $output_path;
    }

    /**
     * Upload pdf.
     *
     * @param pdf $file
     * @param string|path  'pdf/'.$storage_path
     *
     * @return type
     */
    public static function uploadPdf($file, $storage_path)
    {
        if ($file && $file->isValid()) {
            $dirname = 'pdf/'.$storage_path.'/'.$file->getClientOriginalName();

            if (!Storage::exists('pdf/'.$storage_path)) {
                if (!Storage::exists('pdf')) {
                    Storage::makeDirectory('pdf');
                }

                Storage::makeDirectory('pdf/'.$storage_path);
            }

            Storage::put($dirname, file_get_contents($file));

            return $dirname;
        }
        return false;
    }

    /**
     * Remove pdf.
     *
     * @param source $file
     *
     * @return type
     */
    public static function removePdf($file)
    {
        if (Storage::exists($file)) {
            Storage::delete($file);

            return;
        }
        return $file;
    }
}
