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
        'url_id',
        'excerpt',
        'description',
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

    public function models()
    {
        // return $this->belongsToMany(HddModel::class, 'products_hdd_models');
    }

    public function gallery()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\Gallery', 'gallery_id');
    }

    public function comments()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\ProductComment')->orderBy('created_at', 'desc');
    }
}
