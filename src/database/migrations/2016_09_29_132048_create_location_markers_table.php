<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_markers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('key')->unique();
            $table->integer('location_id')->unsigned();
            $table->text('description')->nullable();
            $table->double('latitude', 10, 8);
            $table->double('longitude', 10, 8);
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_markers');
    }
}
