<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalidadesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('localidad', 50);

            $table->bigInteger('provincia_id')
                ->unsigned();

            $table->unique(['provincia_id', 'localidad'], 'provincia_localidad');


            $table->boolean('activo')
                ->default(true);

            $table->timestamp('created_at')
                ->default(date('Y-m-d H:i:s'));

            $table->timestamp('updated_at')
                ->default(date('Y-m-d H:i:s'));

            // Relaciones

            $table->foreign('provincia_id')
                ->references('id')
                ->on('provincias')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('localidades');
    }

}
