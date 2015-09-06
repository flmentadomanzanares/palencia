<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        ));

        $this->call('UserTableSeeder');

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
