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
        return $this->belongsTo('Palencia\Entities\Cursillos', 'cursillo_id');
    }


    /*****************************************************************************************************************
     *
     * Función que devuelve una lista de los cursillos de una comunidad y solicitud determinadas
     *
     *****************************************************************************************************************/
    static public function getCursillosSolicitud($comunidadId=0, $solicitudId=0)
    {
        return SolicitudesEnviadasCursillos::Select('cursillos.*', 'comunidades.comunidad',
            'tipos_participantes.tipo_participante')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas_cursillos.cursillo_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('solicitudes_enviadas', 'solicitudes_enviadas.id', '=', 'solicitudes_enviadas_cursillos.solicitud_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->where('solicitudes_enviadas_cursillos.solicitud_id', '=', $solicitudId)
            ->where('solicitudes_enviadas.comunidad_id', '=', $comunidadId)
            ->where('solicitudes_enviadas_cursillos.activo', true)
            ->orderBy('cursillos.cursillo', 'ASC')
            ->orderBy('cursillos.id', 'ASC')
            ->get();
    }

    /*****************************************************************************************************************
     *
     * Función que devuelve los datos para el listado "Intendencia para Clausura"
     *
     *****************************************************************************************************************/
    static public function imprimirIntendenciaClausura($fecha_inicio = null, $fecha_final = null)
    {

        return SolicitudesEnviadasCursillos::distinct()->Select('paises.pais', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas_cursillos.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas_cursillos.cursillo_id')
            ->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
            ->leftJoin('solicitudes_enviadas', 'solicitudes_enviadas.id', '=', 'solicitudes_enviadas_cursillos.solicitud_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('solicitudes_enviadas_cursillos.activo', true)
            ->where('cursillos.fecha_inicio', '>', $fecha_inicio)
            ->orWhere('cursillos.fecha_inicio', '=', $fecha_inicio)
            ->where('cursillos.fecha_final', '<', $fecha_final)
            ->orWhere('cursillos.fecha_final', '=', $fecha_final)
            ->orderBy('paises.pais', 'ASC')
            ->orderBy('comunidades.comunidad', 'ASC')
            ->get();

    }

    /*****************************************************************************************************************
     *
     * Función que devuelve los datos para el listado "Secretariado"
     *
     *****************************************************************************************************************/
    static public function getSolicitudesComunidad($comunidadId=0)
    {

        return SolicitudesEnviadasCursillos::Select('cursillos.fecha_inicio', 'cursillos.cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas_cursillos.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas_cursillos.cursillo_id')
            ->leftJoin('solicitudes_enviadas', 'solicitudes_enviadas.id', '=', 'solicitudes_enviadas_cursillos.solicitud_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('solicitudes_enviadas_cursillos.activo', true)
            ->where('comunidades.id', '=', $comunidadId)
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.cursillo')
            ->get();

    }
}
