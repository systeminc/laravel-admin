<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
	protected $table = 'blog_articles';

    protected $fillable = [
		'uri_id',
		'title',
		'thumb',
		'content',
		'excerpt',
		'visible',
		'meta_title',
		'meta_description',
		'meta_keywords',  
    ];
}