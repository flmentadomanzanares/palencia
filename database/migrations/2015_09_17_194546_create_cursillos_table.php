<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursillosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursillos', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->string('cursillo',50);

            $table->date('fecha_inicio');

            $table->date('fecha_final');

            $table->text('descripcion');

            $table->bigInteger('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')->references('id')->on('comunidades')->onDelete('cascade');

            $table->enum('tipo_alumnos', ['Hombres', 'Mujeres', 'Mixto'])->default('Mixto');

            $table->enum('tipo_cursillo', ['Interno', 'Externo'])->default('Interno');

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
        Schema::drop('cursillos');
    }

}

