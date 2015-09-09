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

        return [

            'pais'  => $faker->sentence(),
            'activo' => $faker->randomElement(['open', 'open', 'closed']),
            /*'user_id' => $this->createFrom('UserTableSeeder')->id*/
            'user_id' => $this->getRandom('User')->id
        ];

    }

}