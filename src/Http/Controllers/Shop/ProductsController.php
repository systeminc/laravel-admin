<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use SystemInc\LaravelAdmin\Gallery;
use SystemInc\LaravelAdmin\Product;
use SystemInc\LaravelAdmin\ProductCategory;
use SystemInc\LaravelAdmin\ProductVariation;
use SystemInc\LaravelAdmin\SimilarProduct;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;
use SystemInc\LaravelAdmin\Validations\ProductValidation;
use SystemInc\LaravelAdmin\Validations\ProductVariationValidation;
use Validator;

class ProductsController extends Controller
{
    use HelpersTrait;

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $products = Product::orderBy('order_number')->get();

        return view('admin::products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNew(Request $request)
    {
        $product = $this->createNewProduct();
        $this->createNewGalleryForProduct($product);

        return redirect($request->segment(1).'/shop/products/edit/'.$product->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $product_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($product_id)
    {
        $product = Product::find($product_id);

        $products = Product::all();

        $categories = ProductCategory::all();

        return view('admin::products.product', compact('product', 'products', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request, $product_id)
    {
        // validation
        $validation = Validator::make($request->all(), ProductValidation::rules($product_id), ProductValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $original_size = is_array($request->original_size) ? $request->original_size : [];

        $product = Product::find($product_id);

        $product->update($request->all());

        if ($request->hasFile('pdf')) {
            $product->pdf = $this->uploadPdf($request->file('pdf'), 'products');
        }

        if ($request->hasFile('thumb')) {
            $product->thumb = $this->saveImage($request->file('thumb'), 'products', in_array('thumb', $original_size));
        }
        if ($request->hasFile('image')) {
            $product->image = $this->saveImage($request->file('image'), 'products', in_array('image', $original_size));
        }

        if (!empty($request->delete_thumb)) {
            if (Storage::exists('public/'.$product->thumb)) {
                Storage::delete('public/'.$product->thumb);
            }

            $product->thumb = null;
        }

        if (!empty($request->delete_image)) {
            if (Storage::exists('public/'.$product->image)) {
                Storage::delete('public/'.$product->image);
            }

            $product->image = null;
        }

        if ($request->hasFile('thumb_hover')) {
            $product->thumb_hover = $this->saveImage($request->file('thumb_hover'), 'products', in_array('thumb_hover', $original_size));
        }
        if ($request->hasFile('image_hover')) {
            $product->image_hover = $this->saveImage($request->file('image_hover'), 'products', in_array('image_hover', $original_size));
        }

        if (!empty($request->delete_thumb_hover)) {
            if (Storage::exists('public/'.$product->thumb_hover)) {
                Storage::delete('public/'.$product->thumb_hover);
            }

            $product->thumb_hover = null;
        }

        if (!empty($request->delete_image_hover)) {
            if (Storage::exists('public/'.$product->image_hover)) {
                Storage::delete('public/'.$product->image_hover);
            }

            $product->image_hover = null;
        }

        if (!empty($request->delete_pdf)) {
            $product->pdf = $this->removePdf($product->pdf);
        }

        $product->slug = str_slug($request->slug);
        $product->save();

        return redirect($request->segment(1).'/shop/products/edit/'.$product->id)->with('success', 'Saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $product_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDelete(Request $request, $product_id)
    {
        $product = Product::find($product_id);

        $gallery = Gallery::whereTitle($product->gallery->title)->first();

        foreach ($gallery->images as $image) {
            Storage::delete(
                Storage::exists('public/'.$image->source) ? 'public/'.$image->source : '',
                Storage::exists('public/'.$image->thumb_source) ? 'public/'.$image->thumb_source : '',
                Storage::exists('public/'.$image->mobile_source) ? 'public/'.$image->mobile_source : ''
            );

            $image->delete();
        }
        Storage::exists('public/'.$product->pdf) ? 'public/'.$product->pdf : '';

        Storage::exists('public/'.$product->image) ? 'public/'.$product->image : '';
        Storage::exists('public/'.$product->image_hover) ? 'public/'.$product->image_hover : '';
        Storage::exists('public/'.$product->thumb) ? 'public/'.$product->thumb : '';
        Storage::exists('public/'.$product->thumb_hover) ? 'public/'.$product->thumb_hover : '';

        $gallery->delete();
        $product->delete();

        return redirect($request->segment(1).'/shop/products/')->with('success', 'Item deleted');
    }

    /**
     * Add similar product.
     *
     * @param Request $request
     * @param int     $product_id
     *
     * @return type
     */
    public function postAddSimilar(Request $request, $product_id)
    {
        $similar_product = SimilarProduct::where(['product_id' => $product_id, 'product_similar_id' => $request->product_similar_id])->first();

        if ($similar_product) {
            return back()->with(['similar' => 'This product exists in similar products']);
        }

        SimilarProduct::create([
            'product_id'         => $product_id,
            'product_similar_id' => $request->product_similar_id,
        ]);

        return back();
    }

    /**
     * Delete similar product.
     *
     * @param int $similar_id
     *
     * @return type
     */
    public function getDeleteSimilar($similar_id)
    {
        SimilarProduct::find($similar_id)->delete();

        return back();
    }

    /**
     * Create new product.
     */
    private function createNewProduct()
    {
        $product = new Product();
        $product->title = 'New product';
        $product->slug = 'new-product-'.time();
        $product->save();

        return $product;
    }

    /**
     * Create new gallery for single product.
     */
    private function createNewGalleryForProduct($product)
    {
        $gallery = new Gallery();
        $gallery->title = 'product '.$product->id;
        $gallery->key = 'product'.$product->id;
        $gallery->product_id = $product->id;
        $gallery->save();

        $product->gallery_id = $gallery->id;
        $product->save();

        return true;
    }

    public function getAddVariation($product_id)
    {
        return view('admin::products.addvariation', compact('product_id'));
    }

    public function postSaveVariation(Request $request, $product_id)
    {
        // validation
        $validation = Validator::make($request->all(), ProductVariationValidation::rules(), ProductVariationValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $variation = new ProductVariation();

        $variation->fill($request->all());

        $original_size = is_array($request->original_size) ? $request->original_size : [];

        if ($request->hasFile('image')) {
            $variation->image = $this->saveImage($request->file('image'), 'products', in_array('image', $original_size));
        }

        $variation->price = !empty($request->price) ? $request->price : 0;
        $variation->product_id = $product_id;
        $variation->save();

        return redirect($request->segment(1).'/shop/products/edit/'.$product_id)->with('success', 'Added variation');
    }

    public function getEditVariation($variation_id)
    {
        $variation = ProductVariation::find($variation_id);

        return view('admin::products.editvariation', compact('variation'));
    }

    public function postUpdateVariation(Request $request, $variation_id)
    {
        // validation
        $validation = Validator::make($request->all(), ProductVariationValidation::rules(), ProductVariationValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $variation = ProductVariation::find($variation_id);
        $variation->update($request->all());

        $original_size = is_array($request->original_size) ? $request->original_size : [];

        if ($request->hasFile('image')) {
            $variation->image = $this->saveImage($request->file('image'), 'products', in_array('image', $original_size));
        }

        if (!empty($request->delete_image)) {
            if (Storage::exists('public/'.$variation->image)) {
                Storage::delete('public/'.$variation->image);
            }

            $variation->image = null;
        }
        $variation->price = !empty($request->price) ? $request->price : 0;
        $variation->save();

        return back()->with('success', 'Saved variation');
    }

    public function getDeleteVariation($variation_id)
    {
        $variation = ProductVariation::find($variation_id);

        if (!empty($variation->image)) {
            if (Storage::exists('public/'.$variation->image)) {
                Storage::delete('public/'.$variation->image);
            }
        }

        $variation->delete();

        return back()->with('success', 'Deleted variation');
    }
}
