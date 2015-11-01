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


        ];

    }

}