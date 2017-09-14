<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $fillable = [
        'title',
        'subtitle',
        'thumb',
        'thumb_hover',
        'image',
        'image_hover',
        'video',
        'excerpt',
        'description',
        'order_number',
        'slug',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function products()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\Product');
    }
}
