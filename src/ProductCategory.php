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
        'parent_id',
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

    public function children()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\ProductCategory','parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\ProductCategory', 'parent_id', 'id');
    }
}
