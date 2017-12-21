<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\BlogCategory;
use SystemInc\LaravelAdmin\BlogPost;
use SystemInc\LaravelAdmin\BlogPostComment;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class BlogController extends Controller
{
    use HelpersTrait;

    public function __construct()
    {
        if (config('laravel-admin.modules.blog') == false) {
            return redirect(config('laravel-admin.route_prefix'))->with('error', 'Blog module is disabled in config/laravel-admin.php')->send();
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
        $post = $this->addNewBlogPost();

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
        $data = $request->all();
        
        try {
            $data['published_at'] = Carbon::createFromFormat('m/d/Y h:i', $request->published_at)->toDateTimeString();
        } catch (\Exception $e) {
            //
        }
        a
        $post->update($data);

        $original_size = is_array($request->original_size) ? $request->original_size : [];

        if ($request->hasFile('thumb')) {
            $post->thumb = $this->saveImage($request->file('thumb'), 'blog', in_array('thumb', $original_size));
        }

        if ($request->input('delete_thumb')) {
            if (Storage::exists($post->thumb)) {
                Storage::delete($post->thumb);
            }

            $post->thumb = null;
        }

        if ($request->hasFile('cover')) {
            $post->cover = $this->saveImage($request->file('cover'), 'blog', in_array('cover', $original_size));
        }

        if ($request->input('delete_cover')) {
            if (Storage::exists($post->cover)) {
                Storage::delete($post->cover);
            }

            $post->cover = null;
        }

        $post->slug = str_slug($request->slug);
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

    /**
     * Create new blog post.
     */
    private function addNewBlogPost()
    {
        $post = new BlogPost();
        $post->title = 'New Article';
        $post->slug = 'new-post-'.time();
        $post->save();

        return $post;
    }
}
