<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class ColoresTexto extends Model
{
    protected $tabla = "colores_texto";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    static public function getColores()
    {
        return ColoresTexto::Select('nombre_color', 'codigo_color')
            ->orderBy('codigo_color', 'ASC')
            ->get();
    }
}