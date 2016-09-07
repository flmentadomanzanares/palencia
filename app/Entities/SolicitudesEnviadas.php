<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesEnviadas extends Model
{

    protected $tabla = "solicitudes_enviadas";
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

    static public function getAnyoSolicitudesEnviadasList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $placeHolder = ['0' => $placeHolder];
        $sql = SolicitudesEnviadas::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->where('cursillos.activo', true)
            ->where('solicitudes_enviadas.activo', true)
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }

    static public function getSolicitudesEnviadas(Request $request, $paginateNumber = 25)
    {
        return SolicitudesEnviadas::Select('solicitudes_enviadas.id', 'comunidades.comunidad', 'comunidades.colorFondo',
            'comunidades.colorTexto', 'solicitudes_enviadas.aceptada', 'solicitudes_enviadas.activo', 'solicitudes_enviadas.created_at',
            'solicitudes_enviadas.comunidad_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->Aceptada($request->aceptada)
            ->ComunidadSolicitudesEnviadas($request->get('comunidades'))
            ->SolicitudEnviadaEsActivo($request->get('esActivo'))
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('solicitudes_enviadas.id', 'ASC')
            ->paginate($paginateNumber)
            ->setPath('solicitudesEnviadas');

    }

    static public function imprimirIntendenciaClausura($fecha_inicio = null, $fecha_final = null)
    {

        return SolicitudesEnviadas::distinct()->Select('paises.pais', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('solicitudes_enviadas', 'solicitudes_enviadas.id', '=', 'solicitudes_enviadas_cursillos.solicitud_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas_cursillos.cursillo_id')
            ->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('solicitudes_enviadas.activo', true)
            ->where('cursillos.fecha_inicio', '>', $fecha_inicio)
            ->orWhere('cursillos.fecha_inicio', '=', $fecha_inicio)
            ->where('cursillos.fecha_final', '<', $fecha_final)
            ->orWhere('cursillos.fecha_final', '=', $fecha_final)
            ->orderBy('paises.pais', 'ASC')
            ->orderBy('comunidades.comunidad', 'ASC')
            ->get();

    }

    static public function getSolicitudesComunidad($comunidadId = 0)
    {

        return SolicitudesEnviadas::Select('cursillos.fecha_inicio', 'cursillos.cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas_cursillos.cursillo_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('solicitudes_enviadas.activo', true)
            ->where('comunidades.id', '=', $comunidadId)
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.cursillo')
            ->get();

    }

    static public function getComunidadesSolicitudesEnviadasList($placeHolder = "Comunidades...")
    {

        return ['0' => $placeHolder] + SolicitudesEnviadas::Select('comunidades.id', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->where('comunidades.activo', true)
            ->where('solicitudes_enviadas.activo', true)
            ->orderBy('comunidades.comunidad')
            ->Lists('comunidades.comunidad', 'comunidades.id');

    }

    static public function getCursillosSolicitudesEnviadasList($placeHolder = "Cursillos...")
    {
        return ['0' => $placeHolder] + SolicitudesEnviadas::Select('cursillos.id', 'cursillos.cursillo')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
            ->orderBy('cursillos.cursillo')
            ->where('cursillos.activo', true)
            ->where('solicitudes_enviadas.activo', true)
            ->Lists('cursillos.cursillo', 'cursillos.id');
    }

    static public function getSemanasSolicitudesEnviadas($anyo = 0)
    {
        return SolicitudesEnviadas::Select((DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas')))
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('cursillos.activo', true)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->groupBy('semanas')
            ->orderBy('semanas', 'ASC')
            ->get();
    }

    static public function crearComunidadesCursillos($comunidades = array(), $cursillosIds = array())
    {
        $logs = [];
        $pluralComunidad = count($comunidades) > 1 ? true : false;
        $pluralCursillo = count($cursillosIds) > 1 ? true : false;
        $contadorTotalCursillos = 0;
        $contadorTotalComunidades = 0;
        if (count($cursillosIds) > 0 && count($comunidades) > 0) {
            $cursillos = Cursillos::getAlgunosCursillos($cursillosIds);
            if (count($cursillos) == 0)
                return null;
            foreach ($comunidades as $comunidad) {
                $solicitudEnviada = new SolicitudesEnviadas();
                $solicitudEnviada->comunidad_id = $comunidad[0];
                try {
                    DB::transaction(function ()
                    use ($solicitudEnviada, $comunidad, $cursillos, &$contadorTotalCursillos, &$contadorTotalComunidades, &$logs) {
                        $solicitudEnviada->save();
                        $solicitudesEnviadasCursillos = [];
                        $cursos = [];
                        foreach ($cursillos as $curso) {
                            $solicitudesEnviadasCursillos[] = new SolicitudesEnviadasCursillos(['cursillo_id' => $curso["id"], 'comunidad_id' => $comunidad[0]]);
                            $cursos[] = ["Incluido el cursillo " . $curso->cursillo . " con número " . $curso->num_cursillo . " a la comunidad " . $comunidad[1], "", "ok-circle info icon-size-normal"];
                        }
                        $solicitudEnviada->solicitudes_enviadas_cursillos()->saveMany($solicitudesEnviadasCursillos);
                        $contadorTotalComunidades += 1;
                        $contadorTotalCursillos += count($cursillos);
                        $logs[] = ["Incluida la comunidad " . $comunidad[1] . " en concepto de pendiente de respuesta a la solicitud.", "", "ok-sign green icon-size-large"];
                        foreach ($cursos as $curso) {
                            $logs[] = $curso;
                        }
                    });
                } catch (QueryException $ex) {
                    $logs[] = ["No se han incluido la comunidad " . $comunidad[1] . " a pendiente de respuesta de la solicitud.", "", "exclamation-sign warning icon-size-large"];
                }
            }
            $logs[] = ["Se ha" . ($pluralComunidad ? "n" : "") . " incluido " . $contadorTotalComunidades
                . " comunidad" . ($pluralComunidad ? "es" : "") . " y "
                . $contadorTotalCursillos . " cursillo" . ($pluralCursillo ? "s" : "") . " en la"
                . ($pluralCursillo ? "s" : "") . " solicitud" . ($pluralCursillo ? "es" : "")
                . " pendiente" . ($pluralCursillo ? "s" : "") . " de respuesta" . ($pluralCursillo ? "s" : ""), "", "plus-sign green icon-size-large"];
        } else {
            $logs[] = ["No se han incluido nuevas solicitudes pendientes de respuestas.", "", "info-sign info icon-size-large"];
        }
        return $logs;
    }

    /*****************************************************************************************************************
     *
     * Relacion one to many: solicitud_id_id --> solicitudes_enviadas
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     *****************************************************************************************************************/
    public function solicitudes_enviadas_cursillos()
    {

        return $this->hasMany("Palencia\Entities\SolicitudesEnviadasCursillos", "solicitud_id");
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

    public function scopeAceptada($query, $aceptada = null)
    {
        if (is_numeric($aceptada)) {
            $query->where('solicitudes_enviadas.aceptada', $aceptada == 1 ? true : false);
        }
        return $query;
    }

    public function scopeAnyosCursillos($query, $anyo = 0)
    {
        if (is_numeric($anyo) && $anyo > 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio," % x")'), '=', $anyo);
        }
        return $query;
    }

    public function scopeSemanasCursillos($query, $semana = 0)
    {
        if (is_numeric($semana) && $semana > 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio," % v")'), 'like', $semana);
        }
        return $query;
    }

    public function scopeComunidadSolicitudesEnviadas($query, $comunidadId = 0)
    {

        if (is_numeric($comunidadId) && $comunidadId > 0) {

            $query->where('solicitudes_enviadas.comunidad_id', $comunidadId);
        }
        return $query;
    }

    public function scopeCursilloSolicitudesEnviadas($query, $cursilloId = 0)
    {
        if (is_numeric($cursilloId) && $cursilloId > 0) {
            $query->where('solicitudes_enviadas.cursillo_id', $cursilloId);
        }
        return $query;
    }

    public function scopeSolicitudEnviadaEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('solicitudes_enviadas.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }
}
