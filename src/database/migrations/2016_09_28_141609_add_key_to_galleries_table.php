<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SystemInc\LaravelAdmin\Gallery;

class AddKeyToGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('key')->after('title');
        });

        Gallery::orderBy('id')->each(function ($gallery, $key) {
            Gallery::find($gallery->id)->update(['key' => 'gallery_'.$gallery->id]);
        });

        Schema::table('galleries', function (Blueprint $table) {
            $table->string('key')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('key');
        });
    }
}
