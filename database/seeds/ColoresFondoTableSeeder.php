<?php

use Illuminate\Database\Seeder;


class ColoresFondoTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("colores_fondo")->delete();
        /*for ($r=0;$r<=9;$r+=3){
            for ($g=0;$g<=9;$g+=3){
                for ($b=0;$b<=9;$b+=3){
                    DB::table('colores_fondo')->insert(Array('nombre_color' => '', 'codigo_color' => '#'.$r.$g.$b));
                }
            }
        }*/
        //colores_fondo con nombre
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'black', 'codigo_color' => "#000000"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'blue', 'codigo_color' => "#0000ff"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'brown', 'codigo_color' => "#a52a2a"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'cadetblue', 'codigo_color' => "#5f9ea0"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'chocolate', 'codigo_color' => "#d2691e"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'coral', 'codigo_color' => "#ff7f50"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'cornflowerblue', 'codigo_color' => "#6495ed"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'crimson', 'codigo_color' => "#dc143c"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkgoldenrod', 'codigo_color' => "#b8860b"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkgray', 'codigo_color' => "#a9a9a9"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkgreen', 'codigo_color' => "#006400"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkkhaki', 'codigo_color' => "#bdb76b"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkmagenta', 'codigo_color' => "#8b008b"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkolivegreen', 'codigo_color' => "#556b2f"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkorange', 'codigo_color' => "#ff8c00"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkseagreen', 'codigo_color' => "#8fbc8f"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'darkslateblue', 'codigo_color' => "#483d8b"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'deeppink', 'codigo_color' => "#ff1493"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'dimgray', 'codigo_color' => "#696969"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'firebrick', 'codigo_color' => "#b22222"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'goldenrod', 'codigo_color' => "#daa520"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'green', 'codigo_color' => "#008000"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'indianred', 'codigo_color' => "#cd5c5c"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'indigo', 'codigo_color' => "#4b0082"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'ivory', 'codigo_color' => "#fffff0"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lightblue', 'codigo_color' => "#add8e6"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lightgray', 'codigo_color' => "#d3d3d3"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lightgreen', 'codigo_color' => "#90ee90"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lightsalmon', 'codigo_color' => "#ffa07a"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lightsteelblue', 'codigo_color' => "#b0c4de"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lightyellow', 'codigo_color' => "#ffffe0"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'lime', 'codigo_color' => "#00ff00"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'limegreen', 'codigo_color' => "#32cd32"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'magenta', 'codigo_color' => "#ff00ff"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'maroon', 'codigo_color' => "#800000"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'mediumaquamarine', 'codigo_color' => "#66cdaa"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'mediumblue', 'codigo_color' => "#0000cd"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'mediumorchid', 'codigo_color' => "#ba55d3"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'mediumseagreen', 'codigo_color' => "#3cb371"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'mediumspringgreen', 'codigo_color' => "#00fa9a"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'mediumvioletred', 'codigo_color' => "#c71585"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'navy', 'codigo_color' => "#000080"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'olive', 'codigo_color' => "#808000"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'orangered', 'codigo_color' => "#ff4500"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'orchid', 'codigo_color' => "#da70d6"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'palegoldenrod', 'codigo_color' => "#eee8aa"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'palegreen', 'codigo_color' => "#98fb98"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'peru', 'codigo_color' => "#cd853f"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'purple', 'codigo_color' => "#800080"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'red', 'codigo_color' => "#ff0000"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'rosybrown', 'codigo_color' => "#bc8f8f"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'saddlebrown', 'codigo_color' => "#8b4513"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'salmon', 'codigo_color' => "#fa8072"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'slategray', 'codigo_color' => "#708090"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'steelblue', 'codigo_color' => "#4682b4"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'teal', 'codigo_color' => "#008080"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'tomato', 'codigo_color' => "#ff6347"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'turquoise', 'codigo_color' => "#40e0d0"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'violet', 'codigo_color' => "#ee82ee"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => 'yellow', 'codigo_color' => "#ffff00"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#f44336', 'codigo_color' => "#f44336"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#e91e63', 'codigo_color' => "#e91e63"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#9c27b0', 'codigo_color' => "#9c27b0"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#673ab7', 'codigo_color' => "#673ab7"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#3f51b5', 'codigo_color' => "#3f51b5"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#2196f3', 'codigo_color' => "#2196f3"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#03a9f4', 'codigo_color' => "#03a9f4"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#00bcd4', 'codigo_color' => "#00bcd4"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#009688', 'codigo_color' => "#009688"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#4caf50', 'codigo_color' => "#4caf50"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#74d108', 'codigo_color' => "#74d108"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#cddc39', 'codigo_color' => "#cddc39"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#ffeb3b', 'codigo_color' => "#ffeb3b"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#ffc107', 'codigo_color' => "#ffc107"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#ff9800', 'codigo_color' => "#ff9800"));
        DB::table('colores_fondo')->insert(Array('nombre_color' => '#ff5722', 'codigo_color' => "#ff5722"));


    }
}