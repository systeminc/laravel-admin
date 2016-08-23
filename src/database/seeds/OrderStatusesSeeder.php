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
        	'title' => 'Order Created',
        ]);
        OrderStatus::create([
            'title' => 'Order Received',
        ]);
        OrderStatus::create([
            'title' => 'Proforma Sent',
        ]);
        OrderStatus::create([
            'title' => 'Paid',
        ]);
        OrderStatus::create([
            'title' => 'Invoice Sent',
        ]);
        OrderStatus::create([
            'title' => 'Delivered',
        ]);
        OrderStatus::create([
            'title' => 'Packed',
        ]);
    }
}
