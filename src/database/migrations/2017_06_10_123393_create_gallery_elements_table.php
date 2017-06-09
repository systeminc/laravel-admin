<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGalleryElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key');
            $table->string('title');
            $table->text('content')->nullable();
            $table->integer('image_id')->unsigned();
            $table->integer('page_element_type_id')->unsigned();
            $table->integer('order_number')->default(0);
            $table->timestamps();

            $table->foreign('image_id')->references('id')->on('gallery_images')->onDelete('cascade');
            $table->foreign('page_element_type_id')->references('id')->on('page_element_types')->onDelete('cascade');
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
        Schema::drop('gallery_elements');
        Schema::enableForeignKeyConstraints();
    }
}
