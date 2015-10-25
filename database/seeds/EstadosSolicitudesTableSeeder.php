<?php

use Illuminate\Database\Seeder;


class EstadosSolicitudesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("estados_solicitudes")->delete();
        DB::table('estados_solicitudes')->insert(Array('estado_solicitud' => 'Enviado','color'=>'#690'));
        DB::table('estados_solicitudes')->insert(Array('estado_solicitud' => 'Recibido','color'=>'#609'));
    }

}