<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use SystemInc\LaravelAdmin\Facades\SLA as SystemLaravelAdmin;

class GalleryElement extends Model
{
    protected $fillable = [
        'key',
        'title',
        'content',
        'image_id',
        'page_element_type_id',
        'order_number',
    ];

    public function __toString()
    {
        return $this->content;
    }

    public function image()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\GalleryImage');
    }

    public function getContentAttribute($value)
    {
        if (Request::is('administration/*')) {
            return $value;
        }

        switch ($this->page_element_type_id) {
            case 1:
                return nl2br($value);
                break;

            case 2:
                return $value;
                break;

            case 3:
                return SystemLaravelAdmin::getFile($value);
                break;

            default:
                return false;
                break;
        }
    }
}
