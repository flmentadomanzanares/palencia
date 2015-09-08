<?php

use Illuminate\Database\Seeder;
use Palencia\Entities\User;
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder {

    public function run()
    {

        $this->createAdmin();

        $this->createUsers(50);

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


    private function createUsers($total)
    {

        $faker = Faker::create();

        for ($i = 1; $i <= $total; $i++)
        {

            User::create([

            'nombre'  => $faker->firstName($gender = null|'male'|'female'),
            'apellidos' => $faker->lastName,
            'email' => $faker->email,
            'password' => bcrypt('user'),
            'rol' => 'registrado'

            ]);
        }

    }

}