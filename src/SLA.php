<?php

namespace SystemInc\LaravelAdmin;

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
    public function page($page_query = null)
    {
        if (is_string($page_query)) {
            return Page::where(['slug' => $page_query])->first();
        } elseif (is_int($page_query)) {
            return Page::where(['id' => $page_query])->first();
        }

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
        return PageElement::where(['key' => $key])->first();
    }

    /**
     * Instance of Gallery.
     *
     * @return type
     */
    public function gallery($key = false)
    {
        if ($key) {
            return Gallery::where(['key' => $key])->first();
        }

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
     * Instance of Location.
     *
     * @return type
     */
    public function locations()
    {
        return Location::all();
    }

    /**
     * Instance of Location.
     *
     * @return type
     */
    public function location($key)
    {
        return Location::where(['key' => $key])->first();
    }

    /**
     * Instance of map.
     *
     * @return type
     */
    public function maps()
    {
        return Map::all();
    }

    /**
     * Instance of map.
     *
     * @return type
     */
    public function map($key)
    {
        return Map::where(['key' => $key])->first();
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
        return asset('storage').'/'.$filename;
    }
}
