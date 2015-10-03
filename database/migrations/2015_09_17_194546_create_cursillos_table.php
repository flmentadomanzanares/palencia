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

            $table->bigInteger('genero_id')->unsigned();
            $table->foreign('genero_id')->references('id')->on('generos')->onDelete('cascade');

            $table->bigInteger('tipo_cursillo_id')->unsigned();
            $table->foreign('tipo_cursillo_id')->references('id')->on('tipos_cursillos')->onDelete('cascade');

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

