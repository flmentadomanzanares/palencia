<?php

use Faker\Generator;
use Palencia\Entities\Provincias;

class ProvinciasTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new Provincias();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [


        ];

    }


    public function run()
    {

        // datos personalizados
        $this->createProvincia();

        // datos generales
        $this->createMultiple(0);

    }

    private function createProvincia()
    {

        Provincias::create([
            'provincia' => 'Las Palmas',
            'pais_id' => 73

        ]);

    }

}