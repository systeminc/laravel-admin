<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use SystemInc\LaravelAdmin\ProductComment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $comments = ProductComment::orderBy('id', 'desc')->paginate(15);

        return view('admin::products.comments', compact('comments'));
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getApprove($id)
    {
        $product = ProductComment::find($id);
        $product->approved = 1;
        $product->save();

        return back();
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDisapprove($id)
    {
        $product = ProductComment::find($id);
        $product->approved = 0;
        $product->save();

        return back();
    }
}
