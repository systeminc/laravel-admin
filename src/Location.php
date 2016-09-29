<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'title',
        'description',
        'latitude',
        'longitude',
        'image',
        'link',
    ];

    public function marker()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\LocationMarker');
    }
}
