<?php

use Palencia\Entities\Provincias;
use Faker\Generator;

class LocalidadesTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new Localidades();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'title'  => $faker->sentence(),
            'status' => $faker->randomElement(['open', 'open', 'closed']),
            /*'user_id' => $this->createFrom('UserTableSeeder')->id*/
            'user_id' => $this->getRandom('User')->id
        ];

    }

}