<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryElement;
use SystemInc\LaravelAdmin\GalleryImage;
use SystemInc\LaravelAdmin\Page;
use SystemInc\LaravelAdmin\PageElement;

class AjaxController extends Controller
{
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

        Storage::delete($image->source, $image->thumb_source, $image->mobile_source);

        $image->delete();

        return 'Success';
    }

    /**
     * Change subpage order.
     *
     * @param Request $request
     * @param int     $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postChangeSubpagesOrder(Request $request, $page_id)
    {
        foreach ($request->order as $order_number => $id) {
            $subpage = Page::where(['parent_id' => $page_id, 'id' => $id])->first();

            $subpage->order_number = $order_number;

            $subpage->save();
        }

        return 'Success';
    }

    /**
     * Change page element order.
     *
     * @param Request $request
     * @param int     $page_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postChangePageElementOrder(Request $request, $page_id)
    {
        foreach ($request->order as $order_number => $id) {
            $pageElement = PageElement::where(['page_id' => $page_id, 'id' => $id])->first();

            $pageElement->order_number = $order_number;

            $pageElement->save();
        }

        return 'Success';
    }

    /**
     * Change gallery image element order.
     *
     * @param Request $request
     * @param int     $image_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postChangeGalleryImageElementOrder(Request $request, $image_id)
    {
        foreach ($request->order as $order_number => $id) {
            $imageElement = GalleryElement::where(['image_id' => $image_id, 'id' => $id])->first();

            $imageElement->order_number = $order_number;

            $imageElement->save();
        }

        return 'Success';
    }
}
