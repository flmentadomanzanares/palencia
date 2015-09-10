<?php

use Palencia\Entities\User;
use Faker\Generator;

class UserTableSeeder extends BaseSeeder {

    public function getModel()
    {

        //devolvemos nueva instancia de la clase User(modelo)
        return new User();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        // configuracion Faker para tabla users
        return [

            'nombre'  => $faker->firstName($gender = null|'male'|'female'),
            'apellidos' => $faker->lastName,
            'email' => $faker->email,
            'password' => bcrypt('user'),
            'rol' => 'registrado'

        ];

    }

    public function run()
    {

        // datos personalizados
        $this->createAdmin();

        // datos generales
        $this->createMultiple(50);

    }

    private function createAdmin()
    {

        User::create([


            'nombre'  => 'Antonio',
            'apellidos' => 'Becerra Aleman',
            'email' => 'antonio@gmail.com',
            'password' => bcrypt('admin'),
            'rol' => 'administrador'

        ]);

    }

}