<?php

use Illuminate\Database\Seeder;
use SystemInc\LaravelAdmin\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@system-inc.com',
            'password' => bcrypt('admin123'),
        ]);    
    }
}
