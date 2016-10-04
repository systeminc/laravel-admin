<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $fillable = [
        'title',
        'subtitle',
        'thumb',
        'excerpt',
        'description',
        'menu_order',
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
