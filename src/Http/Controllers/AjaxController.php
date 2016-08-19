<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryImage;
use View;

class AjaxController extends Controller
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
     * Change gallery order.
     *
     * @param Request $request
     * @param string  $type
     *
     * @return \Illuminate\Http\Response
     */
    public function postChangeGalleryOrder(Request $request, $type)
    {
        $gallery = Gallery::whereTitle($type)->first();

        foreach ($request->order as $order_number => $id) {
            $image = GalleryImage::where(['gallery_id' => $gallery->id, 'id' => $id])->first();

            $image->order_number = $order_number;

            $image->save();
        }

        return 'Success';
    }

    /**
     * Delete gallery image.
     *
     * @param Request $request
     * @param string  $type
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function postDeleteGalleryImages(Request $request, $type, $id)
    {
        $image = GalleryImage::find($id);

        File::delete($image->source, $image->thumb_source, $image->mobile_source);

        $image->delete();

        return 'Success';
    }
}
