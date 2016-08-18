<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_article_id',
        'name',
        'email',
        'content',
        'approved',
    ];
}
