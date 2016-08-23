<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class BlogPostComment extends Model
{
	protected $table = 'blog_comments';

    protected $fillable = [
		'blog_post_id',
		'name',
		'email',
		'content',
		'approved',  
    ];
}