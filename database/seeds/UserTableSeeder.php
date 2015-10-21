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

            'fullname'  => $faker->name($gender = null|'male'|'female'),
            'name' => $faker->firstName,
            'email' => $faker->email,
            'password' => bcrypt('user'),
            'rol_id' => 2

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
            'fullname'  => 'Antonio Becerra Aleman',
            'name' => 'Antonio',
            'email' => 'antonio@gmail.com',
            'password' => bcrypt('admin'),
            'rol_id' => 4
        ]);
        User::create([
            'fullname'  => 'Francisco Luis Mentado Manzanares',
            'name' => 'Fmentado',
            'email' => 'a@a.es',
            'password' => bcrypt('fmentado'),
            'rol_id' => 4
        ]);

    }

}