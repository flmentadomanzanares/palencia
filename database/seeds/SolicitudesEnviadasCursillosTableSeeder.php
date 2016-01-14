<?php

use Palencia\Entities\SolicitudesEnviadasCursillos;
use Faker\Generator;

class SolicitudesEnviadasCursillosTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new SolicitudesEnviadasCursillos();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'solicitud_id'  => $this->getRandom('SolicitudesEnviadas')->id,
            'cursillo_id' => $this->getRandom('Cursillos')->id,


        ];

    }

}