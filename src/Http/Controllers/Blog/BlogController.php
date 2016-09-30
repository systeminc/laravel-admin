<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;
use Storage;
use SystemInc\LaravelAdmin\BlogCategory;
use SystemInc\LaravelAdmin\BlogPost;
use SystemInc\LaravelAdmin\BlogPostComment;

class BlogController extends Controller
{
    public function __construct()
    {
        if (config('laravel-admin.modules.blog') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'This modules is disabled in config/laravel-admin.php')->send();
        }
    }

    /**
     * Display a listing of the items.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $posts = BlogPost::orderBy('created_at', 'desc')->paginate(10);
        $comments = BlogPostComment::orderBy('created_at', 'desc')->paginate(10);

        return view('admin::blog.index', compact('posts', 'comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostNew(Request $request)
    {
        $post = new BlogPost();
        $post->title = 'New Article';
        $post->uri_id = 'new-post-'.time();
        $post->save();

        return redirect($request->segment(1).'/blog/post-edit/'.$post->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $post_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostEdit($post_id)
    {
        $post = BlogPost::find($post_id);
        $categories = BlogCategory::all();

        return view('admin::blog.post', compact('post', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int                      $post_id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request, $post_id)
    {
        $post = BlogPost::find($post_id);
        $post->update($request->all());

        $image = $request->file('thumb');

        if ($image && $image->isValid()) {
            $image_name = str_random(5);

            $original = '/'.$image_name.'.'.$image->getClientOriginalExtension();
            $dirname = 'images/blog'.$original;

            $original_image = Image::make($image)
                ->fit(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                })->encode();

            Storage::put($dirname, $original_image);

            $post->thumb = $dirname;
        }

        if ($request->input('delete_thumb')) {
            if (Storage::exists($post->thumb)) {
                Storage::delete($post->thumb);
            }

            $post->thumb = null;
        }

        $post->save();

        return redirect($request->segment(1).'/blog/post-edit/'.$post->id)->with('success', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $post_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostDelete(Request $request, $post_id)
    {
        $post = BlogPost::find($post_id)->delete();

        return redirect($request->segment(1).'/blog/')->with('success', 'Item deleted');
    }

    /**
     * @param int $comment_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getApproveComment($comment_id)
    {
        $post = BlogPostComment::find($comment_id);
        $post->approved = 1;
        $post->save();

        return back();
    }

    /**
     * @param int $comment_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDisapproveComment($comment_id)
    {
        $post = BlogPostComment::find($comment_id);
        $post->approved = 0;
        $post->save();

        return back();
    }
}
