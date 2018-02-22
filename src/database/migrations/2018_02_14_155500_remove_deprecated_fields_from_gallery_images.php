<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class removeDeprecatedFieldsFromGalleryImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropColumn('path_source');
            $table->dropColumn('thumb_source');
            $table->dropColumn('mobile_source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->string('path_source');
            $table->string('thumb_source');
            $table->string('mobile_source');
        });
    }
}
