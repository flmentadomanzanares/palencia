<?php

use Palencia\Entities\SolicitudesRecibidasCursillos;
use Faker\Generator;

class SolicitudesRecibidasCursillosTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new SolicitudesRecibidasCursillos();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'solicitud_id'  => $this->getRandom('SolicitudesRecibidas')->id,
            'cursillo_id' => $this->getRandom('Cursillos')->id

        ];

    }

}