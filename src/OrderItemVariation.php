<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class OrderItemVariation extends Model
{
    protected $fillable = [
        'order_item_id',
        'product_variation_id',
    ];

    public function orderItem()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\OrderItem');
    }

    public function productVariation()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\ProductVariation');
    }
}
