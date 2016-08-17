<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

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
}