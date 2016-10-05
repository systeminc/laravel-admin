<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUriKeyAndUrlIdToSlug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->renameColumn('uri_id', 'slug');
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->renameColumn('uri', 'slug');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('url_id', 'slug');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->renameColumn('uri', 'slug');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('uri_key', 'slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->renameColumn('slug', 'uri_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('slug', 'url_id');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->renameColumn('slug', 'uri');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->renameColumn('slug', 'uri_key');
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->renameColumn('slug', 'uri');
        });
    }
}
