<?php

use Illuminate\Database\Seeder;


class ColoresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table("colores")->delete();
        for ($r=0;$r<=9;$r+=3){
            for ($g=0;$g<=9;$g+=3){
                for ($b=0;$b<=9;$b+=3){
                    DB::table('colores')->insert(Array('nombre_color' => '', 'codigo_color' => '#'.$r.$g.$b));
                }
            }
        }
        /*Colores con nombre
        DB::table('colores')->insert(Array('nombre_color' => 'aliceblue', 'codigo_color' => "#f0f8ff"));
        DB::table('colores')->insert(Array('nombre_color' => 'antiquewhite', 'codigo_color' => "#faebd7"));
        DB::table('colores')->insert(Array('nombre_color' => 'aqua', 'codigo_color' => "#00ffff"));
        DB::table('colores')->insert(Array('nombre_color' => 'aquamarine', 'codigo_color' => "#7fffd4"));
        DB::table('colores')->insert(Array('nombre_color' => 'azure', 'codigo_color' => "#f0ffff"));
        DB::table('colores')->insert(Array('nombre_color' => 'beige', 'codigo_color' => "#f5f5dc"));
        DB::table('colores')->insert(Array('nombre_color' => 'bisque', 'codigo_color' => "#ffe4c4"));
        DB::table('colores')->insert(Array('nombre_color' => 'black', 'codigo_color' => "#000000"));
        DB::table('colores')->insert(Array('nombre_color' => 'blanchedalmond', 'codigo_color' => "#ffebcd"));
        DB::table('colores')->insert(Array('nombre_color' => 'blue', 'codigo_color' => "#0000ff"));
        DB::table('colores')->insert(Array('nombre_color' => 'blueviolet', 'codigo_color' => "#8a2be2"));
        DB::table('colores')->insert(Array('nombre_color' => 'brown', 'codigo_color' => "#a52a2a"));
        DB::table('colores')->insert(Array('nombre_color' => 'burlywood', 'codigo_color' => "#deb887"));
        DB::table('colores')->insert(Array('nombre_color' => 'cadetblue', 'codigo_color' => "#5f9ea0"));
        DB::table('colores')->insert(Array('nombre_color' => 'chartreuse', 'codigo_color' => "#7fff00"));
        DB::table('colores')->insert(Array('nombre_color' => 'chocolate', 'codigo_color' => "#d2691e"));
        DB::table('colores')->insert(Array('nombre_color' => 'coral', 'codigo_color' => "#ff7f50"));
        DB::table('colores')->insert(Array('nombre_color' => 'cornflowerblue', 'codigo_color' => "#6495ed"));
        DB::table('colores')->insert(Array('nombre_color' => 'cornsilk', 'codigo_color' => "#fff8dc"));
        DB::table('colores')->insert(Array('nombre_color' => 'crimson', 'codigo_color' => "#dc143c"));
        DB::table('colores')->insert(Array('nombre_color' => 'cyan', 'codigo_color' => "#00ffff"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkblue', 'codigo_color' => "#00008b"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkcyan', 'codigo_color' => "#008b8b"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkgoldenrod', 'codigo_color' => "#b8860b"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkgray', 'codigo_color' => "#a9a9a9"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkgreen', 'codigo_color' => "#006400"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkgrey', 'codigo_color' => "#a9a9a9"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkkhaki', 'codigo_color' => "#bdb76b"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkmagenta', 'codigo_color' => "#8b008b"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkolivegreen', 'codigo_color' => "#556b2f"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkorange', 'codigo_color' => "#ff8c00"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkorchid', 'codigo_color' => "#9932cc"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkred', 'codigo_color' => "#8b0000"));
        DB::table('colores')->insert(Array('nombre_color' => 'darksalmon', 'codigo_color' => "#e9967a"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkseagreen', 'codigo_color' => "#8fbc8f"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkslateblue', 'codigo_color' => "#483d8b"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkslategray', 'codigo_color' => "#2f4f4f"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkslategrey', 'codigo_color' => "#2f4f4f"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkturquoise', 'codigo_color' => "#00ced1"));
        DB::table('colores')->insert(Array('nombre_color' => 'darkviolet', 'codigo_color' => "#9400d3"));
        DB::table('colores')->insert(Array('nombre_color' => 'deeppink', 'codigo_color' => "#ff1493"));
        DB::table('colores')->insert(Array('nombre_color' => 'deepskyblue', 'codigo_color' => "#00bfff"));
        DB::table('colores')->insert(Array('nombre_color' => 'dimgray', 'codigo_color' => "#696969"));
        DB::table('colores')->insert(Array('nombre_color' => 'dimgrey', 'codigo_color' => "#696969"));
        DB::table('colores')->insert(Array('nombre_color' => 'dodgerblue', 'codigo_color' => "#1e90ff"));
        DB::table('colores')->insert(Array('nombre_color' => 'firebrick', 'codigo_color' => "#b22222"));
        DB::table('colores')->insert(Array('nombre_color' => 'floralwhite', 'codigo_color' => "#fffaf0"));
        DB::table('colores')->insert(Array('nombre_color' => 'forestgreen', 'codigo_color' => "#228b22"));
        DB::table('colores')->insert(Array('nombre_color' => 'fuchsia', 'codigo_color' => "#ff00ff"));
        DB::table('colores')->insert(Array('nombre_color' => 'gainsboro', 'codigo_color' => "#dcdcdc"));
        DB::table('colores')->insert(Array('nombre_color' => 'ghostwhite', 'codigo_color' => "#f8f8ff"));
        DB::table('colores')->insert(Array('nombre_color' => 'gold', 'codigo_color' => "#ffd700"));
        DB::table('colores')->insert(Array('nombre_color' => 'goldenrod', 'codigo_color' => "#daa520"));
        DB::table('colores')->insert(Array('nombre_color' => 'gray', 'codigo_color' => "#808080"));
        DB::table('colores')->insert(Array('nombre_color' => 'green', 'codigo_color' => "#008000"));
        DB::table('colores')->insert(Array('nombre_color' => 'greenyellow', 'codigo_color' => "#adff2f"));
        DB::table('colores')->insert(Array('nombre_color' => 'grey', 'codigo_color' => "#808080"));
        DB::table('colores')->insert(Array('nombre_color' => 'honeydew', 'codigo_color' => "#f0fff0"));
        DB::table('colores')->insert(Array('nombre_color' => 'hotpink', 'codigo_color' => "#ff69b4"));
        DB::table('colores')->insert(Array('nombre_color' => 'indianred', 'codigo_color' => "#cd5c5c"));
        DB::table('colores')->insert(Array('nombre_color' => 'indigo', 'codigo_color' => "#4b0082"));
        DB::table('colores')->insert(Array('nombre_color' => 'ivory', 'codigo_color' => "#fffff0"));
        DB::table('colores')->insert(Array('nombre_color' => 'khaki', 'codigo_color' => "#f0e68c"));
        DB::table('colores')->insert(Array('nombre_color' => 'lavender', 'codigo_color' => "#e6e6fa"));
        DB::table('colores')->insert(Array('nombre_color' => 'lavenderblush', 'codigo_color' => "#fff0f5"));
        DB::table('colores')->insert(Array('nombre_color' => 'lawngreen', 'codigo_color' => "#7cfc00"));
        DB::table('colores')->insert(Array('nombre_color' => 'lemonchiffon', 'codigo_color' => "#fffacd"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightblue', 'codigo_color' => "#add8e6"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightcoral', 'codigo_color' => "#f08080"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightcyan', 'codigo_color' => "#e0ffff"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightgoldenrodyellow', 'codigo_color' => "#fafad2"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightgray', 'codigo_color' => "#d3d3d3"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightgreen', 'codigo_color' => "#90ee90"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightgrey', 'codigo_color' => "#d3d3d3"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightpink', 'codigo_color' => "#ffb6c1"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightsalmon', 'codigo_color' => "#ffa07a"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightseagreen', 'codigo_color' => "#20b2aa"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightskyblue', 'codigo_color' => "#87cefa"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightslategray', 'codigo_color' => "#778899"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightslategrey', 'codigo_color' => "#778899"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightsteelblue', 'codigo_color' => "#b0c4de"));
        DB::table('colores')->insert(Array('nombre_color' => 'lightyellow', 'codigo_color' => "#ffffe0"));
        DB::table('colores')->insert(Array('nombre_color' => 'lime', 'codigo_color' => "#00ff00"));
        DB::table('colores')->insert(Array('nombre_color' => 'limegreen', 'codigo_color' => "#32cd32"));
        DB::table('colores')->insert(Array('nombre_color' => 'linen', 'codigo_color' => "#faf0e6"));
        DB::table('colores')->insert(Array('nombre_color' => 'magenta', 'codigo_color' => "#ff00ff"));
        DB::table('colores')->insert(Array('nombre_color' => 'maroon', 'codigo_color' => "#800000"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumaquamarine', 'codigo_color' => "#66cdaa"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumblue', 'codigo_color' => "#0000cd"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumorchid', 'codigo_color' => "#ba55d3"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumpurple', 'codigo_color' => "#9370db"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumseagreen', 'codigo_color' => "#3cb371"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumslateblue', 'codigo_color' => "#7b68ee"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumspringgreen', 'codigo_color' => "#00fa9a"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumturquoise', 'codigo_color' => "#48d1cc"));
        DB::table('colores')->insert(Array('nombre_color' => 'mediumvioletred', 'codigo_color' => "#c71585"));
        DB::table('colores')->insert(Array('nombre_color' => 'midnightblue', 'codigo_color' => "#191970"));
        DB::table('colores')->insert(Array('nombre_color' => 'mintcream', 'codigo_color' => "#f5fffa"));
        DB::table('colores')->insert(Array('nombre_color' => 'mistyrose', 'codigo_color' => "#ffe4e1"));
        DB::table('colores')->insert(Array('nombre_color' => 'moccasin', 'codigo_color' => "#ffe4b5"));
        DB::table('colores')->insert(Array('nombre_color' => 'navajowhite', 'codigo_color' => "#ffdead"));
        DB::table('colores')->insert(Array('nombre_color' => 'navy', 'codigo_color' => "#000080"));
        DB::table('colores')->insert(Array('nombre_color' => 'oldlace', 'codigo_color' => "#fdf5e6"));
        DB::table('colores')->insert(Array('nombre_color' => 'olive', 'codigo_color' => "#808000"));
        DB::table('colores')->insert(Array('nombre_color' => 'olivedrab', 'codigo_color' => "#6b8e23"));
        DB::table('colores')->insert(Array('nombre_color' => 'orange', 'codigo_color' => "#ffa500"));
        DB::table('colores')->insert(Array('nombre_color' => 'orangered', 'codigo_color' => "#ff4500"));
        DB::table('colores')->insert(Array('nombre_color' => 'orchid', 'codigo_color' => "#da70d6"));
        DB::table('colores')->insert(Array('nombre_color' => 'palegoldenrod', 'codigo_color' => "#eee8aa"));
        DB::table('colores')->insert(Array('nombre_color' => 'palegreen', 'codigo_color' => "#98fb98"));
        DB::table('colores')->insert(Array('nombre_color' => 'paleturquoise', 'codigo_color' => "#afeeee"));
        DB::table('colores')->insert(Array('nombre_color' => 'palevioletred', 'codigo_color' => "#db7093"));
        DB::table('colores')->insert(Array('nombre_color' => 'papayawhip', 'codigo_color' => "#ffefd5"));
        DB::table('colores')->insert(Array('nombre_color' => 'peachpuff', 'codigo_color' => "#ffdab9"));
        DB::table('colores')->insert(Array('nombre_color' => 'peru', 'codigo_color' => "#cd853f"));
        DB::table('colores')->insert(Array('nombre_color' => 'pink', 'codigo_color' => "#ffc0cb"));
        DB::table('colores')->insert(Array('nombre_color' => 'plum', 'codigo_color' => "#dda0dd"));
        DB::table('colores')->insert(Array('nombre_color' => 'powderblue', 'codigo_color' => "#b0e0e6"));
        DB::table('colores')->insert(Array('nombre_color' => 'purple', 'codigo_color' => "#800080"));
        DB::table('colores')->insert(Array('nombre_color' => 'red', 'codigo_color' => "#ff0000"));
        DB::table('colores')->insert(Array('nombre_color' => 'rosybrown', 'codigo_color' => "#bc8f8f"));
        DB::table('colores')->insert(Array('nombre_color' => 'royalblue', 'codigo_color' => "#4169e1"));
        DB::table('colores')->insert(Array('nombre_color' => 'saddlebrown', 'codigo_color' => "#8b4513"));
        DB::table('colores')->insert(Array('nombre_color' => 'salmon', 'codigo_color' => "#fa8072"));
        DB::table('colores')->insert(Array('nombre_color' => 'sandybrown', 'codigo_color' => "#f4a460"));
        DB::table('colores')->insert(Array('nombre_color' => 'seagreen', 'codigo_color' => "#2e8b57"));
        DB::table('colores')->insert(Array('nombre_color' => 'seashell', 'codigo_color' => "#fff5ee"));
        DB::table('colores')->insert(Array('nombre_color' => 'sienna', 'codigo_color' => "#a0522d"));
        DB::table('colores')->insert(Array('nombre_color' => 'silver', 'codigo_color' => "#c0c0c0"));
        DB::table('colores')->insert(Array('nombre_color' => 'skyblue', 'codigo_color' => "#87ceeb"));
        DB::table('colores')->insert(Array('nombre_color' => 'slateblue', 'codigo_color' => "#6a5acd"));
        DB::table('colores')->insert(Array('nombre_color' => 'slategray', 'codigo_color' => "#708090"));
        DB::table('colores')->insert(Array('nombre_color' => 'slategrey', 'codigo_color' => "#708090"));
        DB::table('colores')->insert(Array('nombre_color' => 'snow', 'codigo_color' => "#fffafa"));
        DB::table('colores')->insert(Array('nombre_color' => 'springgreen', 'codigo_color' => "#00ff7f"));
        DB::table('colores')->insert(Array('nombre_color' => 'steelblue', 'codigo_color' => "#4682b4"));
        DB::table('colores')->insert(Array('nombre_color' => 'tan', 'codigo_color' => "#d2b48c"));
        DB::table('colores')->insert(Array('nombre_color' => 'teal', 'codigo_color' => "#008080"));
        DB::table('colores')->insert(Array('nombre_color' => 'thistle', 'codigo_color' => "#d8bfd8"));
        DB::table('colores')->insert(Array('nombre_color' => 'tomato', 'codigo_color' => "#ff6347"));
        DB::table('colores')->insert(Array('nombre_color' => 'turquoise', 'codigo_color' => "#40e0d0"));
        DB::table('colores')->insert(Array('nombre_color' => 'violet', 'codigo_color' => "#ee82ee"));
        DB::table('colores')->insert(Array('nombre_color' => 'wheat', 'codigo_color' => "#f5deb3"));
        DB::table('colores')->insert(Array('nombre_color' => 'white', 'codigo_color' => "#ffffff"));
        DB::table('colores')->insert(Array('nombre_color' => 'whitesmoke', 'codigo_color' => "#f5f5f5"));
        DB::table('colores')->insert(Array('nombre_color' => 'yellow', 'codigo_color' => "#ffff00"));
        DB::table('colores')->insert(Array('nombre_color' => 'yellowgreen', 'codigo_color' => "#9acd32"));
        */
    }
}