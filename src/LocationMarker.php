<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class LocationMarker extends Model
{
    protected $fillable = [
	    'title',
		'key',
		'location_id',
		'description',
		'latitude',
		'longitude',
	];

	public function location()
	{
		return $this->belongsTo('SystemInc\LaravelAdmin\Location');
	}
}
