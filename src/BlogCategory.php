<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
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
}
