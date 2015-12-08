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

    static public function getSolicitudesRecibidas(Request $request)
    {
        return SolicitudesRecibidas::Select('solicitudes_recibidas.id', 'comunidades.comunidad', 'cursillos.cursillo',
            'solicitudes_recibidas.cursillo_id', 'cursillos.fecha_inicio', 'solicitudes_recibidas.activo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->CursilloSolicitudesRecibidas($request->get('cursillo'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
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
        $sql = SolicitudesRecibidas::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->where('cursillos.activo', true)
            ->where('solicitudes_recibidas.activo', true)
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
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
     * Relacion many to one: cursillo_id --> cursillos
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function cursillos()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'cursillo_id');
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
}
