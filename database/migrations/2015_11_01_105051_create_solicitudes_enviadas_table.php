<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesEnviadasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_enviadas', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->bigInteger('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')->references('id')->on('comunidades')->onUpdate("cascade");

            $table->bigInteger('cursillo_id')->unsigned();
            $table->foreign('cursillo_id')->references('id')->on('cursillos')->onUpdate("cascade");

            $table->boolean('aceptada')->default(false);

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
        Schema::drop('solicitudes_enviadas');
    }

}


