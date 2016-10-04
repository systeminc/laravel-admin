<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class Page extends Model
{
    use HelpersTrait;

    protected $fillable = [
        'title',
        'elements_prefix',
        'slug',
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

    public function menu()
    {
        return $this->generateNestedPageList(self::all());
    }

    public function tree()
    {
        $pages = self::whereParentId(null)->orderBy('order_number')->get(['id', 'title', 'slug']);

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
            'id'       => $this->id,
            'title'    => $this->title,
            'slug'  => $this->slug,
            'subpages' => $tree,
            ];
    }

    public function subpages()
    {
        return $this->whereParentId($this->id)->get(['id', 'title', 'slug']);
    }

    public function child($parent_id)
    {
        $pages = self::whereParentId($parent_id)->orderBy('order_number')->get(['id', 'title', 'slug']);

        $tree = [];

        foreach ($pages as $page) {
            $tree[] = $page->getTreeBranch();
        }

        return $tree;
    }
}
