<?php

use Faker\Generator;

class LocalidadesTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new Localidades();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [


        ];

    }


    public function run()
    {

        DB::table('localidades')->insert(Array('localidad' => 'Agaete', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Aguimes', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Antigua', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Arrecife', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Artenara', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Arucas', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Betancuria', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Firgas', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Galdar', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Guia', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Haria', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Ingenio', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'La Aldea de San Nicolas', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'La Oliva', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Las Palmas de Gran Canaria', 'provincia_id' => 1, 'activo' => true));
        DB::table('localidades')->insert(Array('localidad' => 'Mogan', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Moya', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Pajara', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Puerto del Rosario', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'San Bartolome', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'San Bartolome de Tirajana', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Santa Brigida', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Santa Lucia de Tirajana', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Tejeda', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Telde', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Teguise', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Teror', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Tias', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Tinajo', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Tuineje', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Valleseco', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Valsequillo', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Vega de San Mateo', 'provincia_id' => 1, 'activo' => false));
        DB::table('localidades')->insert(Array('localidad' => 'Yaiza', 'provincia_id' => 1, 'activo' => false));

    }

}