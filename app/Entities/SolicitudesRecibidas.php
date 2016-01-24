<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesRecibidas extends Model
{

    protected $tabla = "solicitudes_recibidas";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    static public function getAnyoCursillosList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $placeHolder = ['0' => $placeHolder];
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }

    public function scopeComunidadSolicitudesRecibidas($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {

            $query->where('solicitudes_recibidas.comunidad_id', $comunidadId);
        }
        return $query;
    }

    static public function getSolicitudesRecibidas(Request $request)
    {
        return SolicitudesRecibidas::Select('solicitudes_recibidas.id', 'comunidades.comunidad', 'comunidades.color',
            'solicitudes_recibidas.aceptada', 'solicitudes_recibidas.activo', 'solicitudes_recibidas.created_at', 'solicitudes_recibidas.comunidad_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->Aceptada($request->aceptada)
            ->ComunidadSolicitudesRecibidas($request->get('comunidades'))
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('solicitudes_recibidas.id', 'ASC')
            ->paginate(5)
            ->setPath('solicitudesRecibidas');

    }

    static public function imprimirCursillosPorPaises($anyo = 0, $semana = 0)
    {

        return SolicitudesRecibidas::Select('cursillos.num_cursillo', 'cursillos.cursillo', 'comunidades.comunidad', 'paises.pais')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
            ->where('solicitudes_recibidas.aceptada', true)
            ->where('cursillos.activo', true)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v")'), '=', $semana)
            ->orderBy('paises.pais', 'ASC')
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();

    }

    static public function getSolicitudesComunidad($comunidadId = 0)
    {

        return SolicitudesRecibidas::Select('cursillos.fecha_inicio', 'cursillos.cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->where('solicitudes_recibidas.aceptada', true)
            ->where('solicitudes_recibidas.activo', true)
            ->where('comunidades.id', '=', $comunidadId)
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.cursillo')
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

    static public function getAnyoSolicitudesRecibidasList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $placeHolder = ['0' => $placeHolder];
        $sql = SolicitudesRecibidasCursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->where('cursillos.activo', true)
            ->where('solicitudes_recibidas.activo', true)
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }

    static public function getComunidadesSolicitudesRecibidasList($placeHolder = "Comunidades...")
    {

        return ['0' => $placeHolder] + SolicitudesRecibidas::Select('comunidades.id', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->where('comunidades.activo', true)
            ->where('solicitudes_recibidas.activo', true)
            ->orderBy('comunidades.comunidad')
            ->Lists('comunidades.comunidad', 'comunidades.id');

    }

    static public function getCursillosSolicitudesRecibidasList($placeHolder = "Cursillos...")
    {
        return ['0' => $placeHolder] + SolicitudesRecibidas::Select('cursillos.id', 'cursillos.cursillo')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->orderBy('cursillos.cursillo')
            ->where('cursillos.activo', true)
            ->where('solicitudes_recibidas.activo', true)
            ->Lists('cursillos.cursillo', 'cursillos.id');
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
     * Relacion one to many: solicitud_id_id --> solicitudes_recibidas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     *****************************************************************************************************************/
    public function solicitudes_recibidas_cursillos()
    {

        return $this->hasMany("Palencia\Entities\SolicitudesRecibidasCursillos");
    }

    public function scopeAnyosCursillos($query, $anyo = 0)
    {
        if (is_numeric($anyo) && $anyo > 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo);
        }
        return $query;
    }

    public function scopeSemanasCursillos($query, $semana = 0)
    {
        if (is_numeric($semana) && $semana > 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v")'), 'like', $semana);
        }
        return $query;
    }

    public function scopeCursilloSolicitudesRecibidas($query, $cursilloId = 0)
    {
        if (is_numeric($cursilloId) && $cursilloId > 0) {
            $query->where('solicitudes_recibidas.cursillo_id', $cursilloId);
        }
        return $query;
    }

    public function scopeAceptada($query, $aceptada = null)
    {
        if (is_numeric($aceptada)) {
            $query->where('solicitudes_recibidas.aceptada', $aceptada == 1 ? true : false);
        }
        return $query;
    }
}
