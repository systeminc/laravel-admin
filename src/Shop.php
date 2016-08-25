<?php

namespace SystemInc\LaravelAdmin;

class Shop
{
    protected $products;

    public function __get($key)
    {
        if (empty($this->{$key})) {
            $this->{$key} = $this->{$key}();
        }

        return $this->{$key};
    }

    public function products()
    {
        return $this->products = Product::all();
    }
}
