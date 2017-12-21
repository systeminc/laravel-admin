<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_category_id',
        'slug',
        'title',
        'thumb',
        'content',
        'excerpt',
        'visible',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'cover',
        'published_at',
        'author',
    ];

    protected $dates = ['published_at'];

    public function comments()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\BlogPostComment', 'blog_post_id');
    }

    public function categories()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\BlogCategory', 'blog_category_id');
    }
}
