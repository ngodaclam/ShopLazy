<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent')->nullable();
            $table->string('type');
            $table->bigInteger('order')->default(1);
            $table->bigInteger('count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent')->references('id')->on('taxonomies')->onDelete('cascade');
        });

        Schema::create('taxonomy_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->unsignedInteger('locale_id');
            $table->unsignedBigInteger('taxonomy_id');
            $table->timestamps();
            $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
        });

        Schema::create('taxonomy_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('taxonomy_id');
            $table->string('key');
            $table->longText('value');
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
        });

        Schema::create('taxonomy_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->default('featured');
            $table->unsignedBigInteger('taxonomy_id');
            $table->unsignedBigInteger('file_id');
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author');
            $table->unsignedBigInteger('parent')->nullable();
            $table->bigInteger('order')->default(1);
            $table->string('type')->default('post');
            $table->string('status')->default('draft');
            $table->string('comment_status')->default('close');
            $table->bigInteger('comment_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent')->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::create('post_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('excerpt');
            $table->longText('content');
            $table->string('slug')->unique();
            $table->unsignedInteger('locale_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();
            $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::create('post_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id');
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::create('post_taxonomy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('taxonomy_id');
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('taxonomy_id')->references('id')->on('taxonomies')->onDelete('cascade');
        });

        Schema::create('post_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('file_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('content');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('author')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_url')->nullable();
            $table->string('author_ip');
            $table->string('status');
            $table->string('type');
            $table->unsignedBigInteger('parent');
            $table->timestamps();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('comment_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('comment_id');
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->timestamps();
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_meta');
        Schema::dropIfExists('comments');

        Schema::dropIfExists('post_file');
        Schema::dropIfExists('post_detail');
        Schema::dropIfExists('post_meta');
        Schema::dropIfExists('post_taxonomy');
        Schema::dropIfExists('posts');

        Schema::dropIfExists('taxonomy_file');
        Schema::dropIfExists('taxonomy_meta');
        Schema::dropIfExists('taxonomy_detail');
        Schema::dropIfExists('taxonomies');
    }

}
