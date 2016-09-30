<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = [
        'title',
        'key',
        'description',
        'zoom',
        'latitude',
        'longitude',
    ];

    public function location()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\Location', 'map_id');
    }
}
