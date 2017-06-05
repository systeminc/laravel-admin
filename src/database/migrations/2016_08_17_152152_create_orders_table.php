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
            $table->string('id');
            $table->integer('invoice_number');
            $table->integer('order_status_id')->default(1);
            $table->integer('shipment_price');
            $table->integer('total_price');
            $table->datetime('valid_until');
            $table->datetime('date_of_purchase');
            $table->enum('currency', ['USD', 'EUR'])->default('EUR');
            $table->text('note')->nullable();
            $table->string('billing_name');
            $table->string('billing_email');
            $table->string('billing_telephone')->nullable();
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_country');
            $table->string('billing_postcode')->nullable();
            $table->string('billing_contact_person')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_telephone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_country')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_contact_person')->nullable();
            $table->string('parity')->nullable();
            $table->string('term_of_payment')->nullable();
            $table->text('footnote')->nullable();
            $table->integer('show_shipping_address')->default(0)->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::drop('orders');
        Schema::enableForeignKeyConstraints();
    }
}
