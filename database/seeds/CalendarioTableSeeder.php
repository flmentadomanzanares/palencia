<?php

use Illuminate\Database\Seeder;

class CalendarioTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("calendario")->delete();
        for ($i = 0; $i < 5; $i += 1)
            DB::table('calendario')->insert(Array('titulo' => 'título ' . $i, 'cursillo_id' => ($i + 1)));
    }


}