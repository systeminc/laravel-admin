<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'product_category_id',
        'brand_id',
        'title',
        'slug',
        'excerpt',
        'description',
        'long_description',
        'thumb',
        'animation',
        'video',
        'pdf',
        'gallery_id',
        'price',
        'shipment_price',
        'menu_order',
        'visible',
        'featured',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\ProductCategory', 'product_category_id');
    }

    public function gallery()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Gallery', 'gallery_id');
    }

    public function comments()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\ProductComment')->orderBy('created_at', 'desc');
    }

    public function similar()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\SimilarProduct')->orderBy('created_at', 'desc');
    }
}
