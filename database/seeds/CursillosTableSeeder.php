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
            'fecha_inicio' =>date("Y-m-d H:i:s"),
            'fecha_final' => date("Y-m-d H:i:s"),
            'descripcion'  => $faker->text($maxNbChars = 200),
            'comunidad_id'  => $this->getRandom('Comunidades')->id,
            'tipo_participante_id'  => rand(1,3),
            'tipo_cursillo_id'  => rand(1,2),
            'num_cursillo'=> rand(1111,9999)
        ];

    }



}