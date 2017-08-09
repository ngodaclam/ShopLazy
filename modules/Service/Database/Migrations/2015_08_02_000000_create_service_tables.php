<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_scopes', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->string('description');

            $table->timestamps();
        });
        Schema::create('oauth_grants', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->timestamps();
        });
        Schema::create('oauth_grant_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grant_id', 40);
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('grant_id');
            $table->index('scope_id');

            $table->foreign('grant_id')->references('id')->on('oauth_grants')->onDelete('cascade');

            $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
        });
        Schema::create('oauth_clients', function (BluePrint $table) {
            $table->string('id', 40)->primary();
            $table->string('secret', 40);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->timestamps();

            $table->unique([ 'id', 'secret' ]);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::create('oauth_client_endpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->string('redirect_uri');

            $table->timestamps();

            $table->unique([ 'client_id', 'redirect_uri' ]);

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('oauth_client_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('client_id');
            $table->index('scope_id');

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade');

            $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
        });
        Schema::create('oauth_client_grants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->string('grant_id', 40);
            $table->timestamps();

            $table->index('client_id');
            $table->index('grant_id');

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade')->onUpdate('no action');

            $table->foreign('grant_id')->references('id')->on('oauth_grants')->onDelete('cascade')->onUpdate('no action');
        });
        Schema::create('oauth_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->enum('owner_type', [ 'client', 'user' ])->default('user');
            $table->string('owner_id');
            $table->string('client_redirect_uri')->nullable();
            $table->timestamps();

            $table->index([ 'client_id', 'owner_type', 'owner_id' ]);

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('oauth_session_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('session_id');
            $table->index('scope_id');

            $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');

            $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
        });
        Schema::create('oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->integer('session_id')->unsigned();
            $table->string('redirect_uri');
            $table->integer('expire_time');

            $table->timestamps();

            $table->index('session_id');

            $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
        });
        Schema::create('oauth_auth_code_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('auth_code_id', 40);
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('auth_code_id');
            $table->index('scope_id');

            $table->foreign('auth_code_id')->references('id')->on('oauth_auth_codes')->onDelete('cascade');

            $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
        });
        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->integer('session_id')->unsigned();
            $table->integer('expire_time');

            $table->timestamps();

            $table->unique([ 'id', 'session_id' ]);
            $table->index('session_id');

            $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
        });
        Schema::create('oauth_access_token_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('access_token_id', 40);
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('access_token_id');
            $table->index('scope_id');

            $table->foreign('access_token_id')->references('id')->on('oauth_access_tokens')->onDelete('cascade');

            $table->foreign('scope_id')->references('id')->on('oauth_scopes')->onDelete('cascade');
        });
        Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 40)->unique();
            $table->string('access_token_id', 40)->primary();
            $table->integer('expire_time');

            $table->timestamps();

            $table->foreign('access_token_id')->references('id')->on('oauth_access_tokens')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_refresh_tokens');
        Schema::dropIfExists('oauth_access_token_scopes');
        Schema::dropIfExists('oauth_access_tokens');
        Schema::dropIfExists('oauth_auth_code_scopes');
        Schema::dropIfExists('oauth_auth_codes');
        Schema::dropIfExists('oauth_session_scopes');
        Schema::dropIfExists('oauth_sessions');
        Schema::dropIfExists('oauth_client_endpoints');
        Schema::dropIfExists('oauth_client_scopes');
        Schema::dropIfExists('oauth_client_grants');
        Schema::dropIfExists('oauth_clients');
        Schema::dropIfExists('oauth_grant_scopes');
        Schema::dropIfExists('oauth_grants');
        Schema::dropIfExists('oauth_scopes');
    }

}
