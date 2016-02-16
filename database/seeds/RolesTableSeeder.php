<?php

use Faker\Generator;
use Palencia\Entities\Roles;


class RolesTableSeeder extends BaseSeeder
{

    public function getModel()
    {

        return new Roles();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [


        ];

    }


    public function run()
    {

        DB::table('roles')->insert(Array('rol' => 'visitante', 'peso' => 100));
        DB::table('roles')->insert(Array('rol' => 'registrado', 'peso' => 200));
        DB::table('roles')->insert(Array('rol' => 'autorizado', 'peso' => 300));
        DB::table('roles')->insert(Array('rol' => 'administrador', 'peso' => 400));

    }


}