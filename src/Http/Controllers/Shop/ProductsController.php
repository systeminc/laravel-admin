<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\Product;
use SystemInc\LaravelAdmin\ProductCategory;

class ProductsController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $products = Product::orderBy('id','desc')->get();

        return view('admin::products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew(Request $request)
    {
        $product = new Product;
        $product->title = "New product";
        $product->save();

        $gallery = new Gallery;
        $gallery->title = "product " . $product->id;
        $gallery->save();

        $product->gallery_id = $gallery->id;
        $product->save();

        return redirect($request->segment(1).'/shop/products/edit/'.$product->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getEdit($id)
    {
        $product = Product::find($id);

        $products = Product::all();

        $categories = ProductCategory::all();

        return view('admin::products.product', compact('product', 'products', 'categories'));
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

        $product = Product::find($id);
        $product->update($request->all());

        if ($request->file('thumb') && $request->file('thumb')->isValid()) {
            // image doesn't exist
            $filename = $request->file('thumb')->getClientOriginalName();
            $dirname = 'images/products';

            // if image name exists
            $i = 1;
            while (File::exists($dirname . "/" . $filename)) {
                $fileParts = pathinfo($filename);
                $filename = rtrim($fileParts['filename'], "_".($i-1)) . "_$i." . $fileParts['extension'];
                $i++;
            }

            $request->file('thumb')->move($dirname, $filename);
            $product->thumb = $dirname . "/" . $filename;
        }

        if ($request->input('delete_thumb')) {

            if (File::exists($product->thumb)) {
                File::delete($product->thumb);
            }
            $product->thumb = null;
        }

        if ($request->file('pdf') && $request->file('pdf')->isValid()) {
            // image doesn't exist
            $filename = $request->file('pdf')->getClientOriginalName();
            $dirname = 'pdfs';

            // if image name exists
            $i = 1;
            while (File::exists($dirname . "/" . $filename)) {
                $fileParts = pathinfo($filename);
                $filename = rtrim($fileParts['filename'], "_".($i-1)) . "_$i." . $fileParts['extension'];
                $i++;
            }

            $request->file('pdf')->move($dirname, $filename);
            $product->pdf = $dirname . "/" . $filename;
        }

        if ($request->input('delete_pdf')) {

            if (File::exists($product->pdf)) {
                File::delete($product->pdf);
            }
            $product->pdf = null;
        }
        $product->save();

        return redirect($request->segment(1).'/shop/products/edit/'.$product->id)->with('success', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $id)
    {
        $product = Product::find($id);

        $gallery = Gallery::whereTitle($product->gallery->title)->first();

        foreach ($gallery->images as $image) {
            File::delete($image->source, $image->thumb_source, $image->mobile_source);

            $image->delete();
        }
        File::delete($product->pdf);

        $gallery->delete();
        $product->delete();

        return redirect($request->segment(1).'/shop/products/')->with('success', 'Item deleted');
    }
}
