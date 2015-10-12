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
        Schema::create('calendarios', function(Blueprint $table)
        {
            $table->bigIncrements('id');

            $table->string('titulo',30);

            $table->string('color')->default('white');

            $table->bigInteger('cursillo_id')->unsigned();
            $table->foreign('cursillo_id')->references('id')->on('cursillos')->onDelete('cascade');

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
        Schema::drop('calendarios');
    }

}

