<?php

namespace SystemInc\LaravelAdmin;

use Storage;

class SLA
{
    /**
     * Instance of BlogPost.
     *
     * @return type
     */
    public function blog()
    {
        return new Blog();
    }

    /**
     * Instance of Shop.
     *
     * @return type
     */
    public function shop()
    {
        return new Shop();
    }

    /**
     * Get file from storage(Image, PDF,...).
     *
     * @param string $filename
     *
     * @return string
     */
    public function getFile($filename)
    {
        return config('laravel-admin.route_prefix').'/uploads/'.$filename;
    }
}