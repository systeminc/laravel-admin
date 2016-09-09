<?php

namespace SystemInc\LaravelAdmin;

use Storage;

class SLA
{
    /**
     * Instance of Blog.
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
     * Instance of Page.
     *
     * @return type
     */
    public function page()
    {
        return new Page();
    }

    /**
     * Get page element.
     *
     * @param string $key
     *
     * @return type
     */
    public function element($key)
    {
        return PageElement::whereKey($key)->first();
    }

    /**
     * Instance of Gallery.
     *
     * @return type
     */
    public function gallery()
    {
        return new Gallery();
    }

    /**
     * Instance of Subscribe.
     *
     * @return type
     */
    public function lead()
    {
        return new Subscribe();
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
