<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use SystemInc\LaravelAdmin\Scopes\OrderScope;

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

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope());
    }

    public function products()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\Product');
    }
}
