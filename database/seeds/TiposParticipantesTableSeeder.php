<?php

use Illuminate\Database\Seeder;


class TiposParticipantesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("tipos_participantes")->delete();
        DB::table('tipos_participantes')->insert(Array('tipo_participante' => 'Hombre'));
        DB::table('tipos_participantes')->insert(Array('tipo_participante' => 'Mujer'));
        DB::table('tipos_participantes')->insert(Array('tipo_participante' => 'Mixto'));
    }
}