<?php
use Palencia\Entities\SemanaCursilloComunidades;
use Faker\Generator;

class SemanaCursilloComunidadesTableSeeder extends BaseSeeder {

    public function getModel()
    {

        return new SemanaCursilloComunidades();

    }

    public function getDummyData(Generator $faker, array $customValues = array())
    {

        return [

            'cursillo_id' => $this->getRandom('Cursillos')->id,
            'comunidad_id'  => $this->getRandom('Comunidades')->id,
            'calendario_id'  => $faker->biasedNumberBetween($min = 1, $max = 53, $function = 'sqrt')

        ];

    }

}