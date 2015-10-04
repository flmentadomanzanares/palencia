<?php

use Illuminate\Database\Seeder;


class TiposParticipantesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("tipos_participantes")->delete();
        DB::table('tipos_participantes')->insert(Array('participante' => 'Hombre'));
        DB::table('tipos_participantes')->insert(Array('participante' => 'Mujer'));
        DB::table('tipos_participantes')->insert(Array('participante' => 'Mixto'));
    }
}