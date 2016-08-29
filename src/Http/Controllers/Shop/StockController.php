<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use DB;
use SystemInc\LaravelAdmin\Product;

class StockController extends Controller
{
    /**
     * Get stock of items
     * @return type
     */
    public function getIndex()
    {
        $products = Product::orderBy('title')->get();

        foreach ($products as &$product) {
            $product->ordered = DB::table('orders')
                ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
                ->where('product_id', $product->id)
                ->whereIn('orders.order_status_id', [1, 2, 3])
                ->sum('order_items.quantity');
            $product->ordered = $product->ordered < 0 ? 0 : $product->ordered;

            $product->sold = DB::table('orders')
                ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
                ->where('product_id', $product->id)
                ->whereIn('orders.order_status_id', [4, 5])
                ->sum('order_items.quantity');
            $product->sold = $product->sold < 0 ? 0 : $product->sold;

            $product->need = $product->ordered - $product->stock;
            $product->need = $product->need < 0 ? 0 : $product->need;
        }

        return view('admin::stock.index', compact('products'));
    }
}
