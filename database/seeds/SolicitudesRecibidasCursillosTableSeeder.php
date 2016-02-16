<?php

use Faker\Generator;
use Palencia\Entities\SolicitudesRecibidasCursillos;

class SolicitudesRecibidasCursillosTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new SolicitudesRecibidasCursillos();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'solicitud_id' => $this->getRandom('SolicitudesRecibidas')->id,
            'comunidad_id' => $this->getRandom('SolicitudesRecibidas')->comunidad_id,
            'cursillo_id' => $this->getRandom('Cursillos')->id

        ];

    }

}