<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SystemInc\LaravelAdmin\Database\Seeds\OrderStatusesSeeder::class);
        $this->call(SystemInc\LaravelAdmin\Database\Seeds\PageElementTypeSeeder::class);
    }
}
