<?php

namespace SystemInc\LaravelAdmin\Database\Seeds;

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
        $this->call(OrderStatusesSeeder::class);
        $this->call(PageElementTypeSeeder::class);
    }
}
