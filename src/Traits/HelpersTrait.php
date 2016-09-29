<?php

namespace SystemInc\LaravelAdmin\Traits;

trait HelpersTrait
{
    public function sanitizeUri($uri)
    {
        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-\/]/', '/\/+/', '/-+/'], ['', '/', '-'], $uri)), '/-');
    }

    public function sanitizeUriKey($uri_key)
    {
        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-]/', '/-+/'], ['', '-'], $uri_key)), '-');
    }

    public function sanitizeElements($element)
    {
        return trim(strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $element)), '_');
    }
    
    public function generateNestedPageList($pages, $navigation = '')
    {
        $navigation .= '<ul>';

        foreach ($pages as $page) {
            $navigation .= '<li>';
            $navigation .= '<a href="pages/edit/'.$page->id.'"><b>'.$page->title.'</a>';

            if ($page->subpages()->count()) {
                $navigation = $this->generateNestedPageList($page->subpages(), $navigation);
            }

            $navigation .= '</li>';
        }
        
        $navigation .= '</ul>';

        return $navigation;
    }
}
