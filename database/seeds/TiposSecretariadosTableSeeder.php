<?php

use Illuminate\Database\Seeder;


class TiposSecretariadosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("tipos_secretariados")->delete();
        DB::table('tipos_secretariados')->insert(Array('secretariado' => 'Secretariado Diocesano'));
        DB::table('tipos_secretariados')->insert(Array('secretariado' => 'Secretariado Arquidiocesano'));
        DB::table('tipos_secretariados')->insert(Array('secretariado' => 'Grupo Ejecutivo Diocesano'));
    }
}