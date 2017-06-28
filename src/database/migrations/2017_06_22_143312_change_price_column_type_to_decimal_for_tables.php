<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceColumnTypeToDecimalForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->default(0)->change();
            $table->decimal('shipment_price', 12, 2)->default(0)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_price', 12, 2)->default(0)->change();
            $table->decimal('shipment_price', 12, 2)->default(0)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('custom_price', 12, 2)->default(0)->change();
            $table->decimal('discount', 12, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::getConnection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        Schema::table('products', function (Blueprint $table) {
            $table->integer('price')->default(0)->change();
            $table->integer('shipment_price')->default(0)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_price')->default(0)->change();
            $table->integer('shipment_price')->default(0)->change();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('custom_price')->default(0)->change();
            $table->integer('discount')->default(0)->change();
        });
    }
}
