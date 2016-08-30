<?php

namespace SystemInc\LaravelAdmin;

class Pages
{
    protected $page;

    public function __construct($page)
    {
        return $this->page = Page::whereTitle($page)->first();
    }

    public function __get($key)
    {
        if (empty($this->{$key})) {
            $this->{$key} = $this->{$key}($key);
        }

        return $this->{$key};
    }

    public function getElement($element)
    {
        return PageElement::whereKey($this->page->title.".".$element)->first();
    }

    public function page($page)
    {
        return Page::whereTitle($page)->first();
    }

    public function findPage($page)
    {
        return Page::where('title', 'LIKE', "%$page%")->get();
    }
}
