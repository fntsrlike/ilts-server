<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_clients', function($table)
		{
		    $table->increments('client_id');
		    $table->string('client_key')->unique();
		    $table->string('client_secret');
		    $table->text('from_uri');
		    $table->text('redirect_uri');
		    $table->string('uri_type');
		    $table->string('client_name');
		    $table->text('client_describe');
		    $table->integer('client_owner_uid')->unsigned();
		    $table->timestamps();
		    $table->softDeletes();
		});

		Schema::create('oauth_access_tokens', function($table)
		{
		    $table->increments('token_id');
		    $table->string('access_token')->unique();
		    $table->integer('client_id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    $table->timestamp('expires');
		    $table->string('scope')->nullable();
		    $table->timestamps();
		    $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
