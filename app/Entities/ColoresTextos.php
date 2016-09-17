<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class ColoresTextos extends Model
{
    protected $tabla = "colores_textos";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    static public function getColoresTextos()
    {
        return ColoresTextos::Select('nombre_color', 'codigo_color')
            ->orderBy('codigo_color', 'ASC')
            ->get();
    }
}