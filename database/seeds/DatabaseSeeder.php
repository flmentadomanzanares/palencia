<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{

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
            'roles',
            'users',
            'password_resets',
            'paises',
            'provincias',
            'localidades',
            'tipos_comunicaciones_preferidas',
            'tipos_participantes',
            'tipos_secretariados',
            /*'comunidades',
            'cursillos',
            'solicitudes_enviadas',
            'solicitudes_recibidas',*/
        ));
        $this->call('ColoresTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('PaisesTableSeeder');
        $this->call('ProvinciasTableSeeder');
        $this->call('LocalidadesTableSeeder');
        $this->call('TiposComunicacionesPreferidasTableSeeder');
        $this->call('TiposParticipantesTableSeeder');
        $this->call('TiposSecretariadosTableSeeder');
       /* $this->call('ComunidadesTableSeeder');
        $this->call('CursillosTableSeeder');
        $this->call('SolicitudesEnviadasTableSeeder');
        $this->call('SolicitudesRecibidasTableSeeder');*/

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

        $check = $check ? '1' : '0';

        DB::statement("SET FOREIGN_KEY_CHECKS = $check");


    }

}