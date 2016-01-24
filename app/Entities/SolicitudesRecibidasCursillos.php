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
        return SolicitudesRecibidasCursillos::Select('cursillos.*', 'comunidades.comunidad',
            'tipos_participantes.tipo_participante')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas_cursillos.cursillo_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('solicitudes_recibidas', 'solicitudes_recibidas.id', '=', 'solicitudes_recibidas_cursillos.solicitud_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->where('solicitudes_recibidas_cursillos.solicitud_id', '=', $solicitudId)
            ->where('solicitudes_recibidas.comunidad_id', '=', $comunidadId)
            ->where('solicitudes_recibidas_cursillos.activo', true)
            ->orderBy('cursillos.cursillo', 'ASC')
            ->orderBy('cursillos.id', 'ASC')
            ->get();
    }

    /*****************************************************************************************************************
     *
     * Función para generar datos listado "Cursillos en el Mundo"
     *
     *****************************************************************************************************************/
    static public function imprimirCursillosPorPaises($anyo = 0, $semana = 0)
    {

        return SolicitudesRecibidasCursillos::Select('cursillos.num_cursillo', 'cursillos.cursillo', 'comunidades.comunidad', 'paises.pais')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas_cursillos.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas_cursillos.cursillo_id')
            ->leftJoin('solicitudes_recibidas', 'solicitudes_recibidas.id', '=', 'solicitudes_recibidas_cursillos.solicitud_id')
            ->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
            ->where('solicitudes_recibidas.aceptada', true)
            ->where('cursillos.activo', true)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v")'), '=', $semana)
            ->orderBy('paises.pais', 'ASC')
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();

    }

    static public function getAnyoSolicitudesRecibidasList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $placeHolder = ['0' => $placeHolder];
        $sql = SolicitudesRecibidasCursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas_cursillos.cursillo_id')
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->where('cursillos.activo', true)
            ->where('solicitudes_recibidas_cursillos.activo', true)
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }
    static public function getSemanasSolicitudesRecibidasCursillos($anyo = 0)
    {
        return SolicitudesRecibidasCursillos::Select((DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas')))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas_cursillos.cursillo_id')
            ->leftJoin('solicitudes_recibidas', 'solicitudes_recibidas.id', '=', 'solicitudes_recibidas_cursillos.solicitud_id')
            ->where('solicitudes_recibidas.aceptada', true)
            ->where('cursillos.activo', true)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->groupBy('semanas')
            ->orderBy('semanas', 'ASC')
            ->get();

    }

    static public function getSemanasSolicitudesRecibidas($anyo = 0)
    {
        return SolicitudesRecibidas::Select((DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas')))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->where('solicitudes_recibidas.aceptada', true)
            ->where('cursillos.activo', true)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->groupBy('semanas')
            ->orderBy('semanas', 'ASC')
            ->get();
    }
    /*****************************************************************************************************************
     *
     * Función que devuelve los datos para el listado "Secretariado"
     *
     *****************************************************************************************************************/
    static public function getSolicitudesComunidad($comunidadId = 0)
    {

        return SolicitudesRecibidasCursillos::Select('cursillos.fecha_inicio', 'cursillos.cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas_cursillos.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas_cursillos.cursillo_id')
            ->leftJoin('solicitudes_recibidas', 'solicitudes_recibidas.id', '=', 'solicitudes_recibidas_cursillos.solicitud_id')
            ->where('solicitudes_recibidas.aceptada', true)
            ->where('solicitudes_recibidas_cursillos.activo', true)
            ->where('comunidades.id', '=', $comunidadId)
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.cursillo')
            ->get();

    }
}
