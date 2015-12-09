<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('fullname');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string("foto",100)->default('default.png');
            $table->bigInteger('rol_id')->unsigned()->default(2);
            $table->foreign('rol_id')->references('id')->on('roles')->onUpdate("cascade");
            $table->boolean('activo')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
