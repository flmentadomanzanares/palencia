<?php

use Palencia\Entities\SolicitudesEnviadas;
use Faker\Generator;

class SolicitudesEnviadasTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new SolicitudesEnviadas();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'comunidad_id'  => $this->getRandom('Comunidades')->id,
            'cursillo_id' => $this->getRandom('Cursillos')->id,
            'fecha_envio' => $faker->randomElement(['2015-09-16', '2015-09-21', '2015-10-01']),
            'fecha_respuesta'  => $faker->randomElement(['2015-10-12', '2015-10-03', '2015-10-05']),
            'solicitante'  => $faker->name,
            'receptor' => $faker->name,
            'forma_comunicacion' => $faker->randomElement(['Email', 'Email', 'Carta', 'Telefono']),
            'observaciones'  => $faker->text($maxNbChars = 200)

        ];

    }

}