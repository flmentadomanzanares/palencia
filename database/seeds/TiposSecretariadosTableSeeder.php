<?php

use Illuminate\Database\Seeder;


class TiposSecretariadosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("tipos_secretariados")->delete();
        DB::table('tipos_secretariados')->insert(Array('tipo_secretariado' => 'Secretariado Diocesano'));
        DB::table('tipos_secretariados')->insert(Array('tipo_secretariado' => 'Secretariado Arquidiocesano'));
        DB::table('tipos_secretariados')->insert(Array('tipo_secretariado' => 'Grupo Ejecutivo Diocesano'));
    }
}