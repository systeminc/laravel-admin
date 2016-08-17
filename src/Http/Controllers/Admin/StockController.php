<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use SystemInc\LaravelAdmin\Product;
use DB;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function getIndex()
    {
        $tools = Product::orderBy('title')->get();
        
        foreach ($tools as &$tool) {
        	$tool->ordered = DB::table('orders')
		        ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
		        ->where('tool_id', $tool->id)
		        ->whereIn('orders.order_status_id', [1,2,3])
		        ->sum('order_items.quantity');
        	$tool->ordered = $tool->ordered < 0 ? 0 : $tool->ordered;

        	$tool->sold = DB::table('orders')
		        ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id')
		        ->where('tool_id', $tool->id)
		        ->whereIn('orders.order_status_id', [4,5])
		        ->sum('order_items.quantity');
        	$tool->sold = $tool->sold < 0 ? 0 : $tool->sold;

        	$tool->need = $tool->ordered - $tool->stock;
        	$tool->need = $tool->need < 0 ? 0 : $tool->need;
        }

        return view('admin.stock', compact('tools'));
    }
}