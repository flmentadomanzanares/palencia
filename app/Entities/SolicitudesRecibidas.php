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

    static public function getSolicitudesRecibidas(Request $request, $paginateNumber = 25)
    {
        return SolicitudesRecibidas::Select('solicitudes_recibidas.id', 'comunidades.comunidad', 'comunidades.colorFondo',
            'comunidades.colorTexto', 'solicitudes_recibidas.aceptada', 'solicitudes_recibidas.activo', 'solicitudes_recibidas.created_at',
            'solicitudes_recibidas.comunidad_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->SolicitudRespondida($request->get('respondida'))
            ->ComunidadSolicitudesRecibidas($request->get('comunidades'))
            ->SolicitudRecibidaEsActivo($request->get('esActivo'))
            ->AnyoEnCurso($request->get('esActual'))
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('solicitudes_recibidas.created_at', 'DESC')
            ->paginate($paginateNumber)
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

    static public function crearComunidadesCursillos($comunidades = array(), $cursillosIds = array())
    {
        $logs = [];
        $pluralComunidad = count($comunidades) > 1 ? true : false;
        $pluralCursillo = count($cursillosIds) > 1 ? true : false;
        $contadorTotalCursillos = 0;
        $contadorTotalComunidades = 0;
        //Obtenemos los ids de las comunidades
        $comunidadesIds = array_column($comunidades, 0);
        $cursillos = Cursillos::getAlgunosCursillosConComunidades($comunidadesIds, $cursillosIds);
        if (count($cursillos) == 0)
            return null;
        if (count($cursillosIds) > 0 && count($comunidades) > 0) {
            foreach ($comunidades as $comunidad) {
                $solicitudRecibida = new SolicitudesRecibidas();
                $solicitudRecibida->comunidad_id = $comunidad[0];
                try {
                    DB::transaction(function ()
                    use ($solicitudRecibida, $comunidad, $cursillos, &$contadorTotalCursillos, &$contadorTotalComunidades, &$logs) {
                        $solicitudRecibida->save();
                        $solicitudesRecibidasCursillos = [];
                        $cursos = [];
                        foreach ($cursillos as $curso) {
                            if ($curso->comunidad_id == $comunidad[0]) {
                                $solicitudesRecibidasCursillos[] = new SolicitudesRecibidasCursillos(['cursillo_id' => $curso["id"], 'comunidad_id' => $comunidad[0]]);
                                $cursos[] = ["Incluido el cursillo " . $curso->cursillo . " con número " . $curso->num_cursillo . " a la comunidad " . $comunidad[1], "", "ok-circle info icon-size-normal"];
                                $contadorTotalCursillos += 1;
                            }
                        }
                        $logs[] = ["Incluida la comunidad " . $comunidad[1] . " en concepto de respuesta de solicitud a sus cursillos.", "", "ok-sign green icon-size-large"];
                        $solicitudRecibida->solicitudes_recibidas_cursillos()->saveMany($solicitudesRecibidasCursillos);
                        $contadorTotalComunidades += 1;
                        foreach ($cursos as $curso) {
                            $logs[] = $curso;
                        }
                    });
                } catch (QueryException $ex) {
                    $logs[] = ["No se han incluido la comunidad " . $comunidad[1] . " como respuesta de solicitud  a sus cursillos.", "", "exclamation-sign warning icon-size-large"];
                }
            }
            $logs[] = ["Se ha" . ($pluralComunidad ? "n" : "") . " incluido " . $contadorTotalComunidades
                . " comunidad" . ($pluralComunidad ? "es" : "") . " y "
                . $contadorTotalCursillos . " cursillo" . ($pluralCursillo ? "s" : "") . " en la"
                . ($pluralCursillo ? "s" : "") . " respuesta" . ($pluralCursillo ? "s" : "")
                . " de solicitud pendiente" . ($pluralCursillo ? "s" : ""), "", "plus-sign green icon-size-large"];
        } else {
            $logs[] = ["No se han incluido nuevas respuestas de solicitud.", "", "info-sign info icon-size-large"];
        }
        return $logs;
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

        return $this->hasMany("Palencia\Entities\SolicitudesRecibidasCursillos", "solicitud_id");
    }

    public function scopeComunidadSolicitudesRecibidas($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {

            $query->where('solicitudes_recibidas.comunidad_id', $comunidadId);
        }
        return $query;
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

    public function scopeAnyoEnCurso($query, $esAnyoActual = true)
    {
        if (filter_var($esAnyoActual, FILTER_VALIDATE_BOOLEAN)) {
            $query->where(DB::raw('DATE_FORMAT(solicitudes_recibidas.created_at,"%x")'), '=', date("Y"));
        }
    }

    public function scopeSolicitudRespondida($query, $respondida = true)
    {
        return $query->where('solicitudes_recibidas.aceptada', filter_var($respondida, FILTER_VALIDATE_BOOLEAN));
    }

    public function scopeSolicitudRecibidaEsActivo($query, $esActivo = true)
    {
        return $query->where('solicitudes_recibidas.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
    }
}
