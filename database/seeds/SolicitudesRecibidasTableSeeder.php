<?php

use Faker\Generator;
use Palencia\Entities\SolicitudesRecibidas;

class SolicitudesRecibidasTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new SolicitudesRecibidas();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'comunidad_id' => $this->getRandom('Comunidades')->id

        ];

    }

}