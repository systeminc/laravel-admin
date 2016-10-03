<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('key')->unique();
            $table->integer('map_id')->unsigned()->nullable()->default(null);
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->double('latitude', 10, 8);
            $table->double('longitude', 10, 8);
            $table->string('image')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('marker_image')->nullable();
            $table->integer('order_number')->default(0);
            $table->timestamps();

            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
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
        Schema::drop('locations');
        Schema::enableForeignKeyConstraints();
    }
}
