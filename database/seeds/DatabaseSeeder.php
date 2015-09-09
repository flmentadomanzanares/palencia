<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Borramos todos los registros de las tablas antes de cargarlos de nuevo
        $this->truncateTables(array(

            'users',
            'password_resets',
            'paises',
            'provincias',
            'localidades',
            'comunidades',
            'cursillos',
            'solicitudes_enviadas',
            'solicitudes_recibidas',
            'calendario',
            'semana_cursillo_comunidad'

        ));

        $this->call('UserTableSeeder');
        $this->call('PaisesTableSeeder');
        /*$this->call('ProvinciasTableSeeder');
        $this->call('LocalidadesTableSeeder');
        $this->call('ComunidadesTableSeeder');
        $this->call('CursillosTableSeeder');
        $this->call('SolicitudesEnviadasTableSeeder');
        $this->call('SolicitudesRecibidasTableSeeder');
        $this->call('CalendarioTableSeeder');
        $this->call('SemanaCursilloComunidadTableSeeder');*/

    }

    private function truncateTables(array $tables)
    {


        // Desactivamos el checkeo de claves foraneas
        $this->checkForeignKeys(false);

        // Borramos todos los registros de las tablas antes de cargarlos de nuevo
        foreach ($tables as $table) {

            DB::table($table)->truncate();

        }

        // Activamos el checkeo de claves foraneas
        $this->checkForeignKeys(true);
    }


    // Funcion para activar/desactivar el checkeo de claves foraneas
    private function checkForeignKeys($check)
    {

        $check = $check ? '1': '0';

        DB::statement("SET FOREIGN_KEY_CHECKS = $check");



    }

}
