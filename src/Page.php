<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'uri_key',
        'description',
        'keyword',
        'parent_id',
        'order_number',
    ];

    public function elements()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\PageElement');
    }

    public function element($key)
    {
    	return PageElement::whereKey($key)->first();
    }
}
