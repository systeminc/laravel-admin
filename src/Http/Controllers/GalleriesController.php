<?php

namespace SystemInc\LaravelAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\GalleryElement;
use SystemInc\LaravelAdmin\GalleryImage;
use SystemInc\LaravelAdmin\PageElementType;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\PageElementValidation;
use Validator;

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
    public function postUpdate(Request $request, $gallery_id, $image_id = false)
    {
        $gallery = Gallery::find($gallery_id);

        if ($gallery->key !== $request->key && Gallery::where(['key' => $request->key])->first()) {
            return back()->with(['error' => 'This key exists']);
        }

        $this->uploadImages($request->file('images'), $gallery->id, $image_id);

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
            Storage::delete('public/'.$image->source, 'public/'.$image->thumb_source, 'public/'.$image->mobile_source);

            $image->delete();
        }
        $gallery->delete();

        return redirect(config('laravel-admin.route_prefix').'/galleries');
    }

    /**
     * Edit image.
     *
     * @param int $gallery_id, $image_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getImage($gallery_id, $image_id)
    {
        $image = GalleryImage::find($image_id);
        $element_types = PageElementType::all();

        return view('admin::galleries.image', compact('image', 'element_types', 'gallery_id'));
    }

    /**
     * Create element.
     *
     * @param Request $request
     * @param int     $image_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreateElement(Request $request, $image_id)
    {
        $page_element_type_id = $request->page_element_type_id;

        return view('admin::galleries.elements.add_element', compact('page_element_type_id', 'image_id'));
    }

    /**
     * Post save Element.
     *
     * @param Request $request
     * @param int     $image_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postCreateElement(Request $request, $image_id)
    {
        // validation
        $validation = Validator::make($request->all(), PageElementValidation::rules(), PageElementValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }
        $image = GalleryImage::find($image_id);

        $element = new GalleryElement();

        $element->create([
            'key'                  => $this->sanitizeElements($request->title),
            'title'                => $request->title,
            'content'              => $request->page_element_type_id == 3 ? $this->handleFileElement($request->file('content')) : $request->content,
            'image_id'             => $image_id,
            'page_element_type_id' => $request->page_element_type_id,
        ]);

        return redirect($request->segment(1).'/galleries/image/'.$image->gallery_id.'/'.$image_id)->with('success', 'Element added');
    }

    /**
     * Edit element for page.
     *
     * @param int $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEditElement($element_id)
    {
        $element = GalleryElement::find($element_id);

        $mime = empty($element->content) || $element->page_element_type_id !== 3 ? null : Storage::mimeType('public/'.$element->content);

        return view('admin::galleries.elements.edit-element', compact('element', 'mime'));
    }

    /**
     * Update element.
     *
     * @param Request $request
     * @param int     $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdateElement(Request $request, $element_id)
    {
        // validation
        $validation = Validator::make($request->all(), PageElementValidation::rules(), PageElementValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $element = GalleryElement::find($element_id);
        $image = GalleryImage::find($element->image_id);

        $element->update([
            'key'     => $this->sanitizeElements($request->key),
            'title'   => $request->title,
            'content' => $request->hasFile('content') ? $this->handleFileElement($request->file('content')) : $request->content,
        ]);

        return redirect($request->segment(1).'/galleries/image/'.$image->gallery_id.'/'.$image->id)->with('success', 'Element updated');
    }

    /**
     * Delete element from storage.
     *
     * @param Request $request
     * @param int     $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeleteElement(Request $request, $element_id)
    {
        $element = GalleryElement::find($element_id);
        $image = GalleryImage::find($element->image_id);

        if ($element->page_element_type_id == 3 && !empty($element->content)) {
            Storage::delete('public/'.$element->content);
        }

        $page_id = $element->page_id;
        $element->delete();

        return redirect($request->segment(1).'/galleries/image/'.$image->gallery_id.'/'.$image->id)->with('success', 'Element Deleted');
    }

    /**
     * Delete element's file from storage.
     *
     * @param int $element_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeleteElementFile($element_id)
    {
        $element = GalleryElement::find($element_id);

        Storage::delete('public/'.$element->content);

        $element->content = null;
        $element->save();

        return back();
    }

    /**
     * Store a created images in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    private function uploadImages($images, $gallery_id, $image_id = false)
    {
        if (is_array($images)) {
            foreach (array_filter($images) as $image) {
                if ($image->isValid()) {
                    $image_name = str_random(5);

                    $original = '/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();
                    $thumb = '/thumb/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();
                    $mobile = '/mobile/'.$gallery_id.'-'.$image_name.'.'.$image->getClientOriginalExtension();

                    $original_path = storage_path('public/images/galleries'.$original);

                    $original_image = $this->resizeImage(1920, 1080, 'images/galleries/', 'images/galleries'.$original, $image);
                    $thumb_image = $this->resizeImage(375, 200, 'images/galleries/thumb/', 'images/galleries'.$thumb, $image);
                    $mobile_image = $this->resizeImage(1024, 768, 'images/galleries/mobile/', 'images/galleries'.$mobile, $image);
                }

                $data = [
                    'gallery_id'        => $gallery_id,
                    'source'            => $original_image,
                    'path_source'       => $original_path,
                    'thumb_source'      => $thumb_image,
                    'mobile_source'     => $mobile_image,
                ];

                if ($image_id) {
                    GalleryImage::find($image_id)->update($data);
                } else {
                    GalleryImage::create($data);
                }
            }

            return true;
        }
    }

    /**
     * Handle with file element.
     */
    private function handleFileElement($file)
    {
        if ($file && $file->isValid()) {
            $dirname = 'elements/'.$file->getClientOriginalName();

            Storage::put('public/'.$dirname, file_get_contents($file));

            return $dirname;
        }
    }
}
