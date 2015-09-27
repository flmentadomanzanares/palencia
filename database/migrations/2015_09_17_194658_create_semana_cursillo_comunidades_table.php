<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemanaCursilloComunidadesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semana_cursillo_comunidades', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->bigInteger('cursillo_id')->unsigned();
            $table->foreign('cursillo_id')->references('id')->on('cursillos')->onDelete('cascade');

            $table->bigInteger('comunidad_id')->unsigned();
            $table->foreign('comunidad_id')->references('id')->on('comunidades')->onDelete('cascade');

            $table->bigInteger('calendario_id')->unsigned();
            $table->foreign('calendario_id')->references('id')->on('calendario')->onDelete('cascade');

            $table->timestamp('created_at')->default(date("Y-m-d H:i:s"));

            $table->timestamp('updated_at')->default(date("Y-m-d H:i:s"));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('semana_cursillo_comunidades');
    }

}

