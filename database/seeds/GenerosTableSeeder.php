<?php

use Illuminate\Database\Seeder;


class GenerosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("generos")->delete();
        DB::table('generos')->insert(Array('genero' => 'Hombre'));
        DB::table('generos')->insert(Array('genero' => 'Mujer'));
        DB::table('generos')->insert(Array('genero' => 'Mixto'));
    }
}