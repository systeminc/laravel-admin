<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Storage;

class UploadsController extends Controller
{
    /**
     * Get uploaded file from default storage
     * @param file $filename 
     * @return response
     */
    public function Index($filename)
    {
        if (Storage::exists($filename)) {
            $file = Storage::get($filename);
            $mime = Storage::mimeType($filename);

            return response()->make($file, 200)->header('Content-Type', $mime);
        } else {
            abort(404);
        }
    }
}
