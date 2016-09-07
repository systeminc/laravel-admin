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

    public function tree()
    {
        $pages = self::whereParentId(null)->orderBy('order_number')->get(['id', 'title', 'uri_key']);

        $tree = [];

        foreach ($pages as $page) {
            $tree[] = $page->getTreeBranch();
        }

        return $tree;
    }

    private function getTreeBranch()
    {
        $tree = [];
        $children = $this->subpages();

        foreach ($children as $subpage) {
            $tree[] = $subpage->getTreeBranch();
        }

        return [
            'id' => $this->id, 
            'title' => $this->title, 
            'uri_key' => $this->uri_key, 
            'subpages' => $tree, 
            ];
    }

    public function subpages()
    {
        return $this->whereParentId($this->id)->get(['id', 'title', 'uri_key']);
    }

    public function child($parent_id)
    {
        $pages = self::whereParentId($parent_id)->orderBy('order_number')->get(['id', 'title', 'uri_key']);

        $tree = [];

        foreach ($pages as $page) {
            $tree[] = $page->getTreeBranch();
        }

        return $tree;
    }
}   
