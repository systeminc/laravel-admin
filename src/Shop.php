<?php

namespace SystemInc\LaravelAdmin;

class Shop
{
    protected $products;

    protected $categories;

    protected $comments;

    protected $orders;

    public function __get($key)
    {
        if (empty($this->{$key})) {
            $this->{$key} = $this->{$key}();
        }

        return $this->{$key}->all();
    }

    /**
     * Get Query Billder for Product.
     *
     * @return type
     */
    public function products()
    {
        return new Product();
    }

    /**
     * Get Query Billder for ProductCategory.
     *
     * @return type
     */
    public function categories()
    {
        return new ProductCategory();
    }

    /**
     * Get Query Billder for ProductComment.
     *
     * @return type
     */
    public function comments()
    {
        return new ProductComment();
    }

    /**
     * Get Query Billder for Order.
     *
     * @return type
     */
    public function orders()
    {
        return new Order();
    }
}
