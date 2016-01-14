<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;


class SolicitudesEnviadasCursillos extends Model {

    protected $tabla = "solicitudes_enviadas_cursillos";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    /*****************************************************************************************************************
     *
     * Relacion many to one: solicitud_id --> solicitudes_enviadas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function solicitudes_enviadas()
    {
        return $this->belongsTo('Palencia\Entities\SolicitudesEnviadas', 'solicitud_id');
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
        return SolicitudesEnviadasCursillos::Select('cursillos.cursillo', 'comunidades.comunidad')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas_cursillos.cursillo_id')
            ->leftJoin('solicitudes_enviadas', 'solicitudes_enviadas.id', '=', 'solicitudes_enviadas_cursillos.solicitud_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas_cursillos.comunidad_id')
            ->where('solicitudes_enviadas_cursillos.solicitud_id', '=', $solicitudId)
            ->where('solicitudes_enviadas_cursillos.comunidad_id', '=', $comunidadId)
            ->where('solicitudes_enviadas_cursillos.activo', true)
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

}
