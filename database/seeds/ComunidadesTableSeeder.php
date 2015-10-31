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
            'tipo_secretariado_id' => rand(1,3),
            'responsable' => $faker->name($gender = null|'male'|'female'),
            'direccion'  => $faker->randomElement(['Numancia, 22', 'Escaleritas, 128', 'Carvajal, 32']),
            'cp'  => $faker->randomElement(['35012', '35016', '35018', '35010', '32012']),
            'pais_id' => 73,
            'provincia_id' => 1,
            'localidad_id' => $faker->biasedNumberBetween($min = 1, $max = 34, $function = 'sqrt'),
            'email_solicitud' => $faker->email,
            'email_envio' => $faker->email,
            'web' => $faker->url,
            'facebook' => $faker->url,
            'telefono1' => $faker->randomElement(['615324789', '928276589', '627456896', '615856912']),
            'telefono2' => $faker->randomElement(['', '', '928278956', '928564285']),
            'tipo_comunicacion_preferida_id' =>rand(1,2),
            'observaciones'  => $faker->text($maxNbChars = 200)
            ];
    }

}