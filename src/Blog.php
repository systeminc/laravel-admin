<?php

namespace SystemInc\LaravelAdmin;

class Blog
{
    protected $posts;

    protected $comments;

    protected $categories;

    public function __get($key)
    {
        if (empty($this->{$key})) {
            $this->{$key} = $this->{$key}();
        }

        return $this->{$key}->all();
    }

    /**
     * Get Query Billder for BlogPost.
     *
     * @return type
     */
    public function posts($url_key = false)
    {
        if ($url_key) {
            return BlogPost::whereUriId($url_key)->first();
        } else {
            return new BlogPost();
        }
    }

    /**
     * Get Query Billder for BlogPostComment.
     *
     * @return type
     */
    public function comments()
    {
        return new BlogPostComment();
    }

    /**
     * Get Query Billder for BlogCategory.
     *
     * @return type
     */
    public function categories()
    {
        return new BlogCategory();
    }
}
