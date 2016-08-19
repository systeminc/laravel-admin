<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
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

        return view('admin::categories.categories', compact('categories'));
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

        if ($request->hasFile('thumb') && $request->file('thumb')->isValid()) {
            // image doesn't exist
            $filename = $request->file('thumb')->getClientOriginalName();
            $dirname = 'images/categories';

            // if image name exists
            $i = 1;

            while (File::exists($dirname . "/" . $filename)) {
                $fileParts = pathinfo($filename);
                $filename = rtrim($fileParts['filename'], "_".($i-1)) . "_$i." . $fileParts['extension'];
                $i++;
            }

            $request->file('thumb')->move($dirname, $filename);
            $category->thumb = $dirname . "/" . $filename;
        }

        if ($request->input('delete_thumb')) {

            if (File::exists($category->thumb)) {
                File::delete($category->thumb);
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
