<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class PageElement extends Model
{
	protected $fillable = [
		'key',
		'title',
		'content',
		'page_id',
		'page_element_type_id',
		'order_number',
	];
}
