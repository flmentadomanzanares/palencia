<?php

use Illuminate\Database\Seeder;


class ColoresTextoTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("colores_texto")->delete();
        /*for ($r=0;$r<=9;$r+=3){
            for ($g=0;$g<=9;$g+=3){
                for ($b=0;$b<=9;$b+=3){
                    DB::table('colores_texto')->insert(Array('nombre_color' => '', 'codigo_color' => '#'.$r.$g.$b));
                }
            }
        }*/
        //colores_texto con nombre
        DB::table('colores_texto')->insert(Array('nombre_color' => 'black', 'codigo_color' => "#000000"));
        DB::table('colores_texto')->insert(Array('nombre_color' => 'white', 'codigo_color' => "#ffffff"));
        DB::table('colores_texto')->insert(Array('nombre_color' => 'brown', 'codigo_color' => "#a52a2a"));
        DB::table('colores_texto')->insert(Array('nombre_color' => 'cadetblue', 'codigo_color' => "#5f9ea0"));
    }
}