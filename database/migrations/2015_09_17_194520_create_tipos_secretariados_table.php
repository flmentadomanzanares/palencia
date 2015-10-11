<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposSecretariadosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('tipos_secretariados', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->string('tipo_secretariado',50);

            $table->boolean('activo')->default(true);

            $table->timestamp('created_at')->default(date('Y-m-d H:i:s'));

            $table->timestamp('updated_at')->default(date('Y-m-d H:i:s'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('tipos_secretariados');
	}

}
