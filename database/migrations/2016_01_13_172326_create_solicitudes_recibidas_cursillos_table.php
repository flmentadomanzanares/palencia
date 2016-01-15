<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesRecibidasCursillosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitudes_recibidas_cursillos', function(Blueprint $table)
		{
            $table->bigIncrements('id');

            $table->bigInteger('solicitud_id')->unsigned();
            $table->foreign('solicitud_id')->references('id')->on('solicitudes_recibidas')->onUpdate("cascade");


            $table->bigInteger('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')->references('comunidad_id')->on('solicitudes_recibidas')->onUpdate("cascade");

            $table->bigInteger('cursillo_id')->unsigned();
            $table->foreign('cursillo_id')->references('id')->on('cursillos')->onUpdate("cascade");

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
		Schema::drop('solicitudes_recibidas_cursillos');
	}

}
