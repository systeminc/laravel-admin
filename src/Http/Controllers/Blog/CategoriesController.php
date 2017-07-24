<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\BlogCategory;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\BlogCategoryValidation;
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
        $blogs = BlogCategory::orderBy('title')->get();

        return view('admin::blog_categories.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew()
    {
        $category = new BlogCategory();

        $blogs = BlogCategory::all();

        return view('admin::blog_categories.category', compact('category', 'blogs'));
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
        $category = BlogCategory::find($category_id);

        $blogs = BlogCategory::all();

        return view('admin::blog_categories.category', compact('category', 'blogs'));
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
        $validation = Validator::make($request->all(), BlogCategoryValidation::rules(), BlogCategoryValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $original_size = is_array($request->original_size) ? $request->original_size : [];

        if ($category_id == 'new') {
            $category = new BlogCategory();
        } else {
            $category = BlogCategory::find($category_id);
        }

        $category->fill($request->all());

        $category->thumb = $this->saveImage($request->file('thumb'), 'blog', in_array('thumb', $original_size));

        if ($request->input('delete_thumb')) {
            if (Storage::exists($category->thumb)) {
                Storage::delete($category->thumb);
            }

            $category->thumb = null;
        }
        //REPLACE slug
        $category->slug = str_slug($request->title);

        $category->save();

        return redirect($request->segment(1).'/blog/categories/edit/'.$category->id)->with('success', 'Saved successfully');
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
        $category = BlogCategory::find($category_id)->delete();

        return redirect($request->segment(1).'/blog/categories/')->with('success', 'Item deleted');
    }
}
