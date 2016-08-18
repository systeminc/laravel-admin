<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['product_id', 'quantity'];

    public function order()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Order');
    }

    public function product()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Product')->withTrashed();
    }
}
