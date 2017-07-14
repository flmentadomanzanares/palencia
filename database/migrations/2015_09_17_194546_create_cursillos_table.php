<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCursillosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursillos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cursillo', 50);

            $table->Integer('num_cursillo')->unsigned()->default(0);

            $table->date('fecha_inicio');

            $table->date('fecha_final');

            $table->text('descripcion');

            $table->bigInteger('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')->references('id')->on('comunidades')->onUpdate("cascade");

            $table->bigInteger('tipo_participante_id')->unsigned();
            $table->foreign('tipo_participante_id')->references('id')->on('tipos_participantes')->onUpdate("cascade");

            $table->boolean('esRespuesta')->default(false);

            $table->boolean('esSolicitud')->default(false);

            $table->boolean('activo')->default(true);

            $table->unique(['comunidad_id', 'num_cursillo', 'fecha_inicio'], 'cursillo_numero');

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

