<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Comunidades extends Model {

    protected $tabla="comunidades";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /*****************************************************************************************************************
     *
     * Relacion many to one: paises --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function paises()
    {
        return $this->belongsTo('App\Paises', 'pais_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: provincias --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function provincias()
    {
        return $this->belongsTo('App\Provincias', 'provincia_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: localidades --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function localidades()
    {
        return $this->belongsTo('App\Localidades', 'localidad_id');
    }

}


