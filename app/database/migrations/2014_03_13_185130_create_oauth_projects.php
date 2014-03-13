<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthProjects extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_projects', function($table)
        {
            $table->increments('project_id');
            $table->string('name');
            $table->string('describe');
            $table->integer('devloper_id')->unsigned();;
            $table->string('email');
            $table->string('homepage_url');
            $table->string('logo_url');
            $table->string('privacy_policy_url');
            $table->string('terms_of_service_url');
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
        $prefix = 'bak_' . time() . '_';
        Schema::rename('oauth_projects', $prefix . 'oauth_projects');
    }

}
