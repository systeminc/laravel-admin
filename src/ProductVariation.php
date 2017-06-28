<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'content',
        'image',
        'key',
        'group',
        'price',
        'order_number',
    ];
}
