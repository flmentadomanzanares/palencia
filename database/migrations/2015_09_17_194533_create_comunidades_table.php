<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunidadesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunidades', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->string('comunidad',50);

            $table->boolean('esPropia')->default(false);

            $table->bigInteger('tipo_secretariado_id')->unsigned();
            $table->foreign('tipo_secretariado_id')->references('id')->on('tipos_secretariados')->onUpdate("cascade");

            $table->string('responsable',100);

            $table->string('direccion',100)->nullable();;

            $table->string('direccion_postal',100)->nullable();;

            $table->string('cp',9)->nullable();;

            $table->bigInteger('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises')->onUpdate("cascade");

            $table->bigInteger('provincia_id')->unsigned();
            $table->foreign('provincia_id')->references('id')->on('provincias')->onUpdate("cascade");

            $table->bigInteger('localidad_id')->unsigned();
            $table->foreign('localidad_id')->references('id')->on('localidades')->onUpdate("cascade");

            $table->string('email_solicitud',50)->nullable();;

            $table->string('email_envio',50)->nullable();;

            $table->string('web',50)->nullable();

            $table->string('facebook',50)->nullable();

            $table->string('telefono1',13);

            $table->string('telefono2',13)->nullable();

            $table->bigInteger('tipo_comunicacion_preferida_id')->unsigned();
            $table->foreign('tipo_comunicacion_preferida_id')->references('id')->on('tipos_comunicaciones_preferidas')->onUpdate("cascade");

            $table->text('observaciones');

            $table->boolean('esColaborador')->default(true);

            $table->string('color',7)->default('#000000');

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
        Schema::drop('comunidades');
    }

}
