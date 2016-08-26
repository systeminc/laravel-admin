<?php

namespace SystemInc\LaravelAdmin\Database\Seeds;

use Illuminate\Database\Seeder;
use SystemInc\LaravelAdmin\PageElementType;

class PageElementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PageElementType::create(['title' => 'Text']);
        PageElementType::create(['title' => 'HTML']);
        PageElementType::create(['title' => 'File']);
    }
}
