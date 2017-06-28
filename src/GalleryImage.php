<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use SystemInc\LaravelAdmin\Facades\SLA as LaravelAdminFacade;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_id',
        'source',
        'path_source',
        'thumb_source',
        'mobile_source',
        'order_number',
    ];

    public function getUrlAttribute()
    {
        return LaravelAdminFacade::getFile($this->source);
    }

    public function getAllElements()
    {
        return $this->hasMany(GalleryElement::class, 'image_id')->orderBy('order_number');
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
