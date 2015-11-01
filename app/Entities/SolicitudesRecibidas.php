<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class SolicitudesRecibidas extends Model {

    protected $tabla = "solicitudes_recibidas";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    /*****************************************************************************************************************
     *
     * Relacion many to one: comunidad_id --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function comunidades()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'comunidad_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: cursillo_id --> cursillos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function cursillos()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'cursillo_id');
    }
}
