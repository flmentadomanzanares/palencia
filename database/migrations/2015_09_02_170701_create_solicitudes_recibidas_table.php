<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesRecibidasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitudes_recibidas', function(Blueprint $table)
		{
            $table->bigIncrements('id');

            $table->bigInteger('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')->references('id')->on('comunidades')->onDelete('cascade');

            $table->bigInteger('cursillo_id')->unsigned();
            $table->foreign('cursillo_id')->references('id')->on('cursillos')->onDelete('cascade');

            $table->date('fecha_recibida');

            $table->date('fecha_respondida');

            $table->string('solicitante',100);

            $table->string('receptor',100);

            $table->enum('forma_comunicacion', ['Email', 'Carta', 'Telefono'])->default('Email');

            $table->boolean('aceptada')->default(true);

            $table->text('observaciones');

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
		Schema::drop('solicitudes_recibidas');
	}

}
