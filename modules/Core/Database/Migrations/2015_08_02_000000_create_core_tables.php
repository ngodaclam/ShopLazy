<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code', 2)->unique();
            $table->string('image')->nullable();
            $table->integer('order')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->softDeletes();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 24)->unique()->nullable();
            $table->string('email', 100)->unique();
            $table->string('password', 64);
            $table->string('login_url', 64);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('point');
            $table->text('activation_key')->nullable();
            $table->timestamp('last_visited')->nullable();
            $table->string('type');
            $table->tinyInteger('status');
            $table->unsignedInteger('locale_id')->default(1);
            $table->rememberToken();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('locale_id')->references('id')->on('locales')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('user_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('group')->nullable();
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['group', 'meta_key', 'user_id']);
            $table->index(['group', 'meta_key']);
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('default')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
        Schema::create('assigned_roles', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->unique(['user_id', 'role_id']);
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('module');
            $table->string('module_name')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions'); // assumes a users table
            $table->foreign('role_id')->references('id')->on('roles');
        });
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent')->nullable();
            $table->integer('order')->default(1);
            $table->string('type');
            $table->tinyInteger('status')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->foreign('parent')->references('id')->on('menu')->onDelete('cascade');
        });
        Schema::create('menu_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('url');
            $table->string('image');
            $table->unsignedInteger('menu_id');
            $table->unsignedInteger('locale_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade');
            $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
        });
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author')->nullable();
            $table->string('name')->nullable();
            $table->text('path')->nullable();
            $table->text('url')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('size')->nullable();
            $table->string('mine')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->softDeletes();
        });
        Schema::create('file_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->unsignedBigInteger('file_id');
            $table->unsignedInteger('locale_id');

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
        });
        Schema::create('file_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('file_id');
            $table->string('group')->nullable();
            $table->string('meta_key');
            $table->longText('meta_value');
            $table->unique(['group', 'meta_key']);
            $table->index(['group', 'meta_key']);

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
        Schema::create('user_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('file_id');
            $table->string('type')->nullable();
            $table->unique(['user_id', 'file_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
        Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group')->nullable();
            $table->string('key');
            $table->longText('value');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->unique(['group', 'key']);
            $table->index(['group', 'key']);
        });
        Schema::create('point_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->integer('point_change');
            $table->integer('point_before');
            $table->text('content')->nullable();
            $table->string('status');
            $table->string('type');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function ($table) {
            $table->dropForeign(['author']);
        });

        Schema::dropIfExists('assigned_roles');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');

        Schema::dropIfExists('menu_detail');
        Schema::dropIfExists('menu');

        Schema::dropIfExists('user_file');

        Schema::dropIfExists('file_meta');
        Schema::dropIfExists('file_detail');
        Schema::dropIfExists('files');

        Schema::dropIfExists('user_meta');
        Schema::dropIfExists('users');

        Schema::dropIfExists('locales');

        Schema::dropIfExists('configs');
    }

}