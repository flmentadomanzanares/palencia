<?php

use Palencia\Entities\SolicitudesRecibidas;
use Faker\Generator;

class SolicitudesRecibidasTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new SolicitudesRecibidas();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'comunidad_id'  => $this->getRandom('Comunidades')->id,
            'cursillo_id' => $this->getRandom('Cursillos')->id,
            'fecha_recibida' => $faker->randomElement(['2015-09-16', '2015-09-21', '2015-10-01']),
            'fecha_respondida'  => $faker->randomElement(['2015-10-12', '2015-10-03', '2015-10-05']),
            'solicitante'  => $faker->name,
            'receptor' => $faker->name,
            'forma_comunicacion' => $faker->randomElement(['Email', 'Email', 'Carta', 'Telefono']),
            'observaciones'  => $faker->text($maxNbChars = 200)

        ];

    }

}