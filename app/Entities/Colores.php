<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Colores extends Model
{

    protected $tabla = "colores";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan


    static public function getColores()
    {
        return Colores::Select('nombre_color', 'codigo_color')
            ->orderBy('codigo_color', 'ASC')
            ->get();
    }
}