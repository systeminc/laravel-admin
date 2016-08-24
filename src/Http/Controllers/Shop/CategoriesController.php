<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use SLA;
use SystemInc\LaravelAdmin\ProductCategory;

class CategoriesController extends Controller
{
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
        $category = new ProductCategory;

        $categories = ProductCategory::all();

        return view('admin::categories.category', compact('category', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $category = ProductCategory::find($id);

        $categories = ProductCategory::all();

        return view('admin::categories.category', compact('category', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {
        $id = $request->segment(count($request->segments()));

        if ($id == 'new') {
            $category = new ProductCategory;
        }
        else {
            $category = ProductCategory::find($id);
        }

        $category->fill($request->all());

        $image = $request->file('thumb');

        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $dirname = 'images/categories'.$original;

            $original_image = Image::make($image)
                ->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                })->encode();

            Storage::put($dirname, $original_image);

            $category->thumb = $dirname;
        }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $id)
    {
        $category = ProductCategory::find($id)->delete();

        return redirect($request->segment(1).'/shop/categories/')->with('success', 'Item deleted');
    }
}
