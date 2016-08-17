<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use SystemInc\LaravelAdmin\BlogArticle;
use SystemInc\LaravelAdmin\Gallery;

class BlogController extends Controller
{
    /**
     * Display a listing of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $articles = BlogArticle::orderBy('created_at','desc')->get();
        
        return view('admin.blog.articles', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew(Request $request)
    {
        $article = new BlogArticle;
        $article->title = "New Article";
        $article->uri_id = "new-article-" . time();
        $article->save();

        return redirect($request->segment(1).'/blog/edit/'.$article->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $article = BlogArticle::find($id);

        return view('admin.blog.article', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request)
    {
        $id = $request->segment(4);

        $article = BlogArticle::find($id);
        $article->update($request->all());

        if ($request->file('thumb') && $request->file('thumb')->isValid()) {

            // image doesn't exist
            $filename = $request->file('thumb')->getClientOriginalName();
            $dirname = 'images/blog';

            // if image name exists
            $i = 1;
            while (File::exists($dirname . "/" . $filename)) {
                $fileParts = pathinfo($filename);
                $filename = rtrim($fileParts['filename'], "_".($i-1)) . "_$i." . $fileParts['extension'];
                $i++;
            }

            $request->file('thumb')->move($dirname, $filename);
            $article->thumb = $dirname . "/" . $filename;
        }

        if ($request->input('delete_thumb')) {

            if (File::exists($article->thumb)) {
                File::delete($article->thumb);
            }
            $article->thumb = null;
        }
        $article->save();

        return redirect($request->segment(1).'/blog/edit/'.$article->id)->with('success', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $id)
    {
        $article = BlogArticle::find($id)->delete();

        return redirect($request->segment(1).'/blog/')->with('success', 'Item deleted');
    }
}