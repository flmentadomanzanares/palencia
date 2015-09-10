<?php
use Palencia\Entities\Paises;
use Faker\Generator;

class PaisesTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new Paises();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        // configuracion Faker para tabla users
        return [



        ];

    }


    public function run()
    {

        // datos personalizados
        $this->createPais();

        // datos generales
        $this->createMultiple(0);

    }

    private function createPais()
    {

        Paises::create([

            'pais'  => 'España'

        ]);

    }

}