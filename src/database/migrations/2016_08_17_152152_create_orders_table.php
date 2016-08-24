<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_number');
            $table->integer('order_status_id')->default(1);
            $table->integer('shipment_price');
            $table->integer('total_price');
            $table->datetime('valid_until');
            $table->datetime('date_of_purchase');
            $table->enum('currency', ['USD', 'EUR'])->default('EUR');
            $table->enum('currency_sign', ['USD', 'EUR'])->default('EUR');
            $table->text('note');
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_telephone');
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_country');
            $table->string('billing_postcode');
            $table->string('billing_contact_person');
            $table->string('shipping_name');
            $table->string('shipping_email');
            $table->string('shipping_telephone');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_country');
            $table->string('shipping_postcode');
            $table->string('shipping_contact_person');
            $table->string('parity');
            $table->string('term_of_payment');
            $table->text('footnote');
            $table->integer('show_shipping_address')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
