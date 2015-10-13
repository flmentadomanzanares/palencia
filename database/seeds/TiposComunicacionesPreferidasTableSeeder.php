<?php

use Illuminate\Database\Seeder;


class TiposComunicacionesPreferidasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("tipos_comunicaciones_preferidas")->delete();
        DB::table('tipos_comunicaciones_preferidas')->insert(Array('comunicacion_preferida' => 'Carta'));
        DB::table('tipos_comunicaciones_preferidas')->insert(Array('comunicacion_preferida' => 'Email'));
    }
}