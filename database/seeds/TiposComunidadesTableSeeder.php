<?php

use Illuminate\Database\Seeder;


class TiposComunidadesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("tipos_comunidades")->delete();
        DB::table('tipos_comunidades')->insert(Array('comunidad' => 'Secretariado Diocesano'));
        DB::table('tipos_comunidades')->insert(Array('comunidad' => 'Secretariado Arquidiocesano'));
        DB::table('tipos_comunidades')->insert(Array('comunidad' => 'Grupo Ejecutivo Diocesano'));
    }
}