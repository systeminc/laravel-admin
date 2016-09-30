<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'title',
        'key',
        'map_id',
        'description',
        'address',
        'latitude',
        'longitude',
        'image',
        'thumb_image',
        'marker_image',
        'order_number',
    ];
}
