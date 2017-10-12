<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Storage;

class UploadsController extends Controller
{
    /**
     * Get uploaded file from default storage.
     *
     * @param file $filename
     *
     * @return response
     */
    public function Index($filename)
    {
        if (Storage::exists($filename)) {
            $file = asset('storage').'/'.$filename;

            $imginfo = getimagesize($file);
            header("Content-type: {$imginfo['mime']}");
            readfile($file);

            return readfile($file);
        } else {
            abort(404);
        }
    }
}
