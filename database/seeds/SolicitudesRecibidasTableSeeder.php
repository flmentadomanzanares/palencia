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

            'comunidad_id'  => $this->getRandom('Comunidades')->id

        ];

    }

}