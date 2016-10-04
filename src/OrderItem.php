<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'discount',
        'custom_price',
    ];

    public function order()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Order');
    }

    public function product()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Product')->withTrashed();
    }
}
