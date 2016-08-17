<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id');
            $table->integer('brand_id');
            $table->string('title');
            $table->string('url_id');
            $table->text('excerpt');
            $table->text('description');
            $table->text('thumb');
            $table->text('animation');
            $table->text('video');
            $table->text('pdf');
            $table->integer('gallery_id');
            $table->integer('price');
            $table->integer('shipment_price');
            $table->integer('menu_order');
            $table->integer('visible');
            $table->integer('featured');
            $table->integer('stock')->default(0);
            $table->softDeletes();
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
        Schema::drop('products');
    }
}
