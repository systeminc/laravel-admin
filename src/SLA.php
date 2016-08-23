<?php

namespace SystemInc\LaravelAdmin;

use SystemInc\LaravelAdmin\Blog;
use SystemInc\LaravelAdmin\Product;
use Storage;
use Illuminate\Support\Collection;

class SLA 
{
    /**
     * Instance of Blog model
     * @return type
     */
    public function blog()
    {
        return new Blog;
    }

    /**
     * Instance of Product model
     * @return type
     */
    public function shop()
    {
    	return new Product;
    }

    /**
     * Get file from storage(Image, PDF,...)
     * @param string $filename 
     * @return string
     */
    public function getFile($filename)
    {
        return config('laravel-admin.route_prefix').'/uploads/'.$filename;
    }
}
