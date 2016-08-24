<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'product_id',
    ];

    public function images()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\GalleryImage')->orderBy('order_number');
    }
}
