<?php

namespace SystemInc\LaravelAdmin\Tests\Unit;

use SystemInc\LaravelAdmin\Page;
use SystemInc\LaravelAdmin\Tests\LaravelAdminTestCase;
use SystemInc\LaravelAdmin\Traits\HelpersTrait;

class TraitTest extends LaravelAdminTestCase
{
    use HelpersTrait;

    public function testSanitizeElement()
    {
        $this->assertEquals($this->sanitizeElements('Aa123--1aax\#!adAafaS/ccaa-'), 'aa1231aaxadaafasccaa');
    }

    public function testGenerateNestedPageList()
    {
        $page = factory(Page::class)->create();

        $this->assertEquals($this->generateNestedPageList($page->get()), '<ul class="border"><li><a href="pages/edit/'.$page->id.'">'.$page->title.'</a></li></ul>');
    }
}
