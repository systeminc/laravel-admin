<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddHoverImageToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('thumb_hover')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('thumb_hover')->nullable();
        });
        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('image_hover')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('image_hover')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('thumb_hover');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('thumb_hover');
        });
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('image_hover');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image_hover');
        });
    }
}
