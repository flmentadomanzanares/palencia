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

            $table->enum('tipo_secretariado', ['Secretariado Diocesano', 'Secretariado Arquidiocesano',
                'GED – Grupo Ejecutivo Diocesano', 'Otros'])->default('Secretariado Diocesano');

            $table->string('responsable',100);

            $table->string('direccion',100);

            $table->string('cp',5);

            $table->bigInteger('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('cascade');

            $table->bigInteger('provincia_id')->unsigned();
            $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('cascade');

            $table->bigInteger('localidad_id')->unsigned();
            $table->foreign('localidad_id')->references('id')->on('localidades')->onDelete('cascade');

            $table->string('email1',50);

            $table->string('email2',50);

            $table->string('web',50)->nullable();

            $table->string('facebook',50)->nullable();

            $table->string('telefono1',13);

            $table->string('telefono2',13)->nullable();

            $table->enum('comunicacion_preferida', ['Email', 'Carta'])->default('Email');

            $table->text('observaciones');

            $table->boolean('registrada')->default(false);

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

