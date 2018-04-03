<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use SystemInc\LaravelAdmin\Facades\SLA as LaravelAdminFacade;
use SystemInc\LaravelAdmin\Scopes\OrderScope;

class GalleryImage extends Model
{
    protected $fillable = [
        'gallery_id',
        'source',
        'order_number',
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

    public function getUrlAttribute()
    {
        return LaravelAdminFacade::getFile($this->source);
    }

    public function getAllElements()
    {
        return $this->hasMany(GalleryElement::class, 'image_id');
    }
    
    public function elements()
    {
        return $this->getAllElements();
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
