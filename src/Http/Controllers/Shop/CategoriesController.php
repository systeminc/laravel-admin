<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\ProductCategory;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\CategoryValidation;
use Validator;

class CategoriesController extends Controller
{
    use HelpersTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $categories = ProductCategory::orderBy('order_number')->get();

        return view('admin::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew()
    {
        $category = new ProductCategory();

        $categories = ProductCategory::all();

        return view('admin::categories.category', compact('category', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $category_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($category_id)
    {
        $category = ProductCategory::find($category_id);

        $categories = ProductCategory::all();

        return view('admin::categories.category', compact('category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request, $category_id)
    {
        // validation
        $validation = Validator::make($request->all(), CategoryValidation::rules(), CategoryValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        if ($category_id == 'new') {
            $category = new ProductCategory();
        } else {
            $category = ProductCategory::find($category_id);
        }

        $category->fill($request->all());

        $category->thumb = $request->hasFile('thumb') ? $this->saveImage($request->file('thumb'), 'categories') : $category->thumb;

        if ($request->input('delete_thumb')) {
            if (Storage::exists('public/'.$category->thumb)) {
                Storage::delete('public/'.$category->thumb);
            }

            $category->thumb = null;
        }

        $category->image = $request->hasFile('image') ? $this->saveImage($request->file('image'), 'categories') : $category->image;

        if ($request->input('delete_image')) {
            if (Storage::exists('public/'.$category->image)) {
                Storage::delete('public/'.$category->image);
            }

            $category->image = null;
        }

        $category->thumb_hover = $request->hasFile('thumb_hover') ? $this->saveImage($request->file('thumb_hover'), 'categories') : $category->thumb_hover;

        if ($request->input('delete_thumb_hover')) {
            if (Storage::exists('public/'.$category->thumb_hover)) {
                Storage::delete('public/'.$category->thumb_hover);
            }

            $category->thumb_hover = null;
        }

        $category->image_hover = $request->hasFile('image_hover') ? $this->saveImage($request->file('image_hover'), 'categories') : $category->image_hover;

        if ($request->input('delete_image_hover')) {
            if (Storage::exists('public/'.$category->image_hover)) {
                Storage::delete('public/'.$category->image_hover);
            }

            $category->image_hover = null;
        }
        //REPLACE slug
        $category->slug = str_slug($request->title);

        $category->save();

        return redirect($request->segment(1).'/shop/categories/edit/'.$category->id)->with('success', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $category_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $category_id)
    {
        $category = ProductCategory::find($category_id)->delete();

        return redirect($request->segment(1).'/shop/categories/')->with('success', 'Item deleted');
    }
}
