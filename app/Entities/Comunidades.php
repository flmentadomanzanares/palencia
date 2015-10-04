<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Comunidades extends Model
{

    protected $tabla = "comunidades";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    /*****************************************************************************************************************
     *
     * Relacion many to one: tipo_comunidad --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function tipo_secretariado()
    {
        return $this->belongsTo('App\TiposSecretariados', 'tipo_secretariado_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: tipo_comunidad --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function tipo_comunicacion_preferida()
    {
        return $this->belongsTo('App\TiposComunicacionesPreferidas', 'tipo_comunicacion_preferida_id');
    }

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

    static public function getComunidades()
    {
        return Comunidades::Select('comunidades.comunidad', 'comunidades.responsable', 'comunidades.direccion',
            'tipos_secretariados.secretariado', 'paises.pais', 'provincias.provincia', 'localidades.localidad')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->where('tipos_secretariados.activo', true)
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->where('paises.activo', true)
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->where('provincias.activo', true)
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->where('localidades.activo', true)
            ->orderBy('comunidad', 'ASC')
            ->where('comunidades.activa', true)
            ->paginate(5)
            ->setPath('comunidades');
    }


}


