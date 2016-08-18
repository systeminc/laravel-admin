<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SystemInc\LaravelAdmin\BlogComment;

class BlogCommentsController extends Controller
{
    /**
     * Display a listing of the comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $comments = BlogComment::orderBy('id', 'desc')->paginate(15);

        return view('admin.blog.comments', compact('comments'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getApprove($id)
    {
        $tool = BlogComment::find($id);
        $tool->approved = 1;
        $tool->save();

        return back();
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDisapprove($id)
    {
        $tool = BlogComment::find($id);
        $tool->approved = 0;
        $tool->save();

        return back();
    }
}
