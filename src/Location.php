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
}
