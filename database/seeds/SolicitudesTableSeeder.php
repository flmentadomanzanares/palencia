<?php

use Palencia\Entities\Solicitudes;
use Faker\Generator;

class SolicitudesTableSeeder extends BaseSeeder {

    public function getModel()
    {
        return new Solicitudes();
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
            'comunicacion_preferida_id' => rand(1,2),
            'observaciones'  => $faker->text($maxNbChars = 200)
        ];
    }

}