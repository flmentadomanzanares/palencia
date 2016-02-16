<?php

use Faker\Generator;
use Palencia\Entities\SolicitudesEnviadasCursillos;

class SolicitudesEnviadasCursillosTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new SolicitudesEnviadasCursillos();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'solicitud_id' => $this->getRandom('SolicitudesEnviadas')->id,
            'comunidad_id' => $this->getRandom('SolicitudesEnviadas')->comunidad_id,
            'cursillo_id' => $this->getRandom('Cursillos')->id


        ];

    }

}