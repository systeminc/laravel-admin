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
        $categories = ProductCategory::orderBy('title')->get();

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

        $category->thumb = $this->saveImage($request->file('thumb'), 'categories');

        if ($request->input('delete_thumb')) {
            if (Storage::exists($category->thumb)) {
                Storage::delete($category->thumb);
            }

            $category->thumb = null;
        }
        //REPLACE URI
        $uri = strtolower($request->title);
        $category->uri = str_replace(' ', '-', $uri);

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
