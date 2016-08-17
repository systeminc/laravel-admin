<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_article_id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->text('content');
            $table->integer('approved')->default(0);
            $table->timestamps();

            $table->foreign('blog_article_id')->references('id')->on('blog_articles')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blog_comments');
    }
}
