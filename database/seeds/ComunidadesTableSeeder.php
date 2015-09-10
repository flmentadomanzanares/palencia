<?php

use Palencia\Entities\Comunidades;
use Faker\Generator;

class ComunidadesTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new Comunidades();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'comunidad'  => $faker->company,
            'tipo_secretariado' => $faker->randomElement(['Secretariado Diocesano', 'Secretariado Diocesano', 'Otros']),
            'responsable' => $faker->name($gender = null|'male'|'female'),
            'direccion'  => $faker->randomElement(['Numancia, 22', 'Escaleritas, 128', 'Carvajal, 32']),
            'cp'  => $faker->randomElement(['35012', '35016', '35018', '35010', '32012']),
            'pais_id' => 1,
            'provincia_id' => 1,
            'localidad_id' => $faker->biasedNumberBetween($min = 1, $max = 34, $function = 'sqrt'),
            'email1' => $faker->email,
            'email2' => $faker->email,
            'web' => $faker->url,
            'facebook' => $faker->url,
            'telefono1' => $faker->randomElement(['615324789', '928276589', '627456896', '615856912']),
            'telefono2' => $faker->randomElement(['', '', '928278956', '928564285']),
            'comunicacion_preferida' => $faker->randomElement(['Email', 'Email', 'Carta']),
            'observaciones'  => $faker->text($maxNbChars = 200),
            'registrada' => $faker->randomElement(['1', '1', '0'])

        ];

    }

}