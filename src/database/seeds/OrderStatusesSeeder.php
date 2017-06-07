<?php

namespace SystemInc\LaravelAdmin\Database\Seeds;

use Illuminate\Database\Seeder;
use SystemInc\LaravelAdmin\OrderStatus;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'id'    => -2,
            'title' => 'Refunded',
        ]);
        OrderStatus::create([
            'id'    => -1,
            'title' => 'Not Accepted',
        ]);
        OrderStatus::create([
            'id'    => 0,
            'title' => 'Created',
        ]);
        OrderStatus::create([
            'id'    => 1,
            'title' => 'Accepted',
        ]);
        OrderStatus::create([
            'id'    => 2,
            'title' => 'Paid',
        ]);
        OrderStatus::create([
            'id'    => 3,
            'title' => 'Shipped',
        ]);
        OrderStatus::create([
            'id'    => 4,
            'title' => 'Delivered',
        ]);
    }
}
