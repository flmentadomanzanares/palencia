<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendario', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->smallInteger('year')->length(4)->unsigned();

            $table->date('fecha_inicio');

            $table->date('fecha_final');

            $table->smallInteger('semana_no')->length(2)->unsigned();

            $table->boolean('activo')->default(true);

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
        Schema::drop('calendario');
    }

}

