<?php

use Faker\Generator;
use Palencia\Entities\SolicitudesEnviadas;

class SolicitudesEnviadasTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new SolicitudesEnviadas();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'comunidad_id' => $this->getRandom('Comunidades')->id

        ];

    }

}