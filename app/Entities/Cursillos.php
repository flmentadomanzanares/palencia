<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cursillos extends Model {

    protected $tabla="cursillos";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    public function comunidades()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'comunidad_id');
    }

    public function scopeCursillo($query, $cursillo)
    {
        if (trim($cursillo) != '')
            $query->where('cursillo', 'LIKE', "$cursillo" . '%');
    }

    /*****************************************************************************************************************
     *
     * Obtenemos la lista de valores permitidos del campo enum
     * @return array Lista con los campos
     *
     *****************************************************************************************************************/
    public static function getCursilloEnumValues($field)
    {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM cursillos WHERE Field = '".$field."'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach (explode(',', $matches[1]) as $value) {
            $v = trim($value, "'");
            $enum = array_add($enum, $v, $v);
        }
        return $enum;
    }



/*****************************************************************************************************************
 *
 * Obtenemos la lista de valores permitidos del campo enum tipo_cursillo
 * @return array Lista con los campos
 *
 *****************************************************************************************************************/
/*public static function getCursilloEnumCursillosValues()
{
    $type = DB::select(DB::raw("SHOW COLUMNS FROM cursillos WHERE Field = 'tipoCursillo'"))[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enumCursillos = array();
    foreach (explode(',', $matches[1]) as $value) {
        $v = trim($value, "'");
        $enumCursillos = array_add($enumCursillos, $v, $v);
    }
    return $enumCursillos;
}*/

}
