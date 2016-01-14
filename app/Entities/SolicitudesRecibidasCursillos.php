<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SolicitudesRecibidasCursillos extends Model {

    protected $tabla = "solicitudes_recibidas_cursillos";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    /*****************************************************************************************************************
     *
     * Relacion many to one: solicitud_id --> solicitudes_recibidas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function solicitudes_recibidas()
    {
        return $this->belongsTo('Palencia\Entities\SolicitudesRecibidas', 'solicitud_id');
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
        return $this->belongsTo('Palencia\Entities\Cursillos', 'cursillo_id');
    }

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
     * Función que devuelve una lista de los cursillos de una comunidad y solicitud determinadas
     *
     *****************************************************************************************************************/
    static public function getCursillosSolicitud($comunidadId=0, $solicitudId=0)
    {
        return SolicitudesRecibidasCursillos::Select('cursillos.cursillo', 'comunidades.comunidad')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas_cursillos.cursillo_id')
            ->leftJoin('solicitudes_recibidas', 'solicitudes_recibidas.id', '=', 'solicitudes_recibidas_cursillos.solicitud_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas_cursillos.comunidad_id')
            ->where('solicitudes_recibidas_cursillos.solicitud_id', '=', $solicitudId)
            ->where('solicitudes_recibidas_cursillos.comunidad_id', '=', $comunidadId)
            ->where('solicitudes_recibidas_cursillos.activo', true)
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }
}
