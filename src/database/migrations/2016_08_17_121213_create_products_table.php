<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->integer('product_category_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->string('title');
            $table->string('url_id')->nullable()->default(null);
            $table->text('excerpt')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->text('thumb')->nullable()->default(null);
            $table->text('animation')->nullable()->default(null);
            $table->text('video')->nullable()->default(null);
            $table->text('pdf')->nullable()->default(null);
            $table->integer('gallery_id')->default(0);
            $table->integer('price')->default(0);
            $table->integer('shipment_price')->default(0);
            $table->integer('menu_order')->default(1);
            $table->integer('visible')->default(1);
            $table->integer('featured')->default(1);
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
        Schema::disableForeignKeyConstraints();
        Schema::drop('products');
        Schema::enableForeignKeyConstraints();
    }
}
