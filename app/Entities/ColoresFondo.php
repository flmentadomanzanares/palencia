<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class ColoresFondo extends Model
{
    protected $tabla = "colores_fondo";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    static public function getColoresFondos()
    {
        return ColoresFondo::Select('nombre_color', 'codigo_color')
            ->orderBy('codigo_color', 'ASC')
            ->get();
    }
}