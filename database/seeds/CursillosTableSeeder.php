<?php

use Palencia\Entities\Cursillos;
use Faker\Generator;

class CursillosTableSeeder  extends BaseSeeder {

    public function getModel()
    {

        return new Cursillos();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'cursillo'  => $faker->catchPhrase,
            'fecha_inicio' => '2015-09-09',
            'fecha_final' => $faker->randomElement(['2015-09-16', '2015-09-21', '2015-10-01']),
            'descripcion'  => $faker->text($maxNbChars = 200),
            'comunidad_id'  => $this->getRandom('Comunidades')->id,
            'tipo_alumnos'  => $faker->randomElement(['Hombres', 'Mujeres', 'Mixto', 'Mixto', 'Mixto']),
            'tipo_cursillo'  => $faker->randomElement(['Interno', 'Interno', 'Externo']),
        ];

    }



}