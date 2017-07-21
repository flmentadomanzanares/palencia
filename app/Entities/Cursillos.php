<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cursillos extends Model
{

    protected $tabla = "cursillos";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    /**
     * @param Request $request
     * @return mixed
     */
    static public function getCalendarCursillos(Request $request)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio',
            'cursillos.fecha_final', 'comunidades.comunidad', 'comunidades.colorFondo', 'comunidades.colorTexto')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->FiltroComunidadCursillosTipo($request->get('esPropia'))
            ->FiltroNombreComunidad($request->get('comunidad'))
            ->FiltroAnyosCursillos($request->get('anyo'))
            ->SemanasCursillos($request->get('semana'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    public static function getCursillosList()
    {
        return ['0' => 'Cursillo...'] + Cursillos::Select('id', 'cursillo')
                ->where('activo', true)
                ->orderBy('cursillo', 'ASC')
                ->Lists('cursillo', 'id');
    }

    static public function getCursillos(Request $request, $paginateNumber = 25)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', 'comunidades.colorFondo',
            'comunidades.colorTexto', 'cursillos.activo', 'comunidades.comunidad', 'comunidades.esPropia', 'cursillos.num_cursillo',
            'cursillos.esRespuesta', 'cursillos.esSolicitud', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->ComunidadCursillos($request->get('comunidad'))
            ->FiltroAnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->Cursillo($request->get('cursillo'))
            ->CursilloEsActivo($request->get('esActivo'))
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'DESC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->paginate($paginateNumber)
            ->setPath('cursillos');
    }

    static public function getAlgunosCursillos($cursillosIds = array())
    {
        return Cursillos::Select('cursillos.*', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->whereIn('cursillos.id', $cursillosIds)
            ->get();
    }

    static public function getAlgunosCursillosConComunidades($comunidadesIds = array(), $cursillosIds = array())
    {
        return Cursillos::Select('cursillos.*', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->whereIn('comunidades.id', $comunidadesIds)
            ->whereIn('cursillos.id', $cursillosIds)
            ->get();
    }

    /**
     * @param int $comunidadId
     * @param array $cursillos
     * @return mixed
     */
    static public function setCursillosEsSolicitud($cursillosIds = array())
    {
        $recordsCount = 0;
        if (count($cursillosIds) > 0) {
            DB::transaction(function () use (&$recordsCount, $cursillosIds) {
                $ids = implode(",", $cursillosIds);
                $recordsCount = DB::update("update cursillos set esSolicitud=true  where (esSolicitud = false and activo = true and id in ($ids))");
            });
        }
        return $recordsCount;
    }

    static public function setCursillosEsRespuesta($cursillosIds = array())
    {
        $recordsCount = 0;
        if (count($cursillosIds) > 0) {
            DB::transaction(function () use (&$recordsCount, $cursillosIds) {
                $ids = implode(",", $cursillosIds);
                $recordsCount = DB::update("update cursillos set esRespuesta=true  where (esRespuesta = false and activo = true and id in ($ids))");

            });
        }
        return $recordsCount;
    }

    /**
     * @param int $comunidad
     * @param int $anyo
     * @param int $incluirSolicitudesAnteriores
     * @return mixed
     */
    static public function getCursillosPDFSolicitud($comunidad = 0, $anyo = 0, $cursillos = [])
    {
        return Cursillos::select('cursillos.id', 'cursillos.comunidad_id', 'cursillos.num_cursillo', 'cursillos.cursillo', 'cursillos.esRespuesta',
            'cursillos.fecha_inicio', 'cursillos.fecha_final', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            'cursillos.esSolicitud')
            ->leftJoin('comunidades', 'cursillos.comunidad_id', '=', 'comunidades.id')
            ->ComunidadCursillos($comunidad)
            ->FiltroAnyosCursillos($anyo)
            ->WhereIn("cursillos.id", $cursillos)
            ->Where('cursillos.activo', true)
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();
    }

    static public function getCursillosPDFRespuesta($comunidad = 0, $anyo = 0, $incluirRespuestasAnteriores = false)
    {
        return Cursillos::select('cursillos.id', 'cursillos.comunidad_id', 'cursillos.num_cursillo', 'cursillos.cursillo', 'cursillos.esRespuesta',
            'cursillos.fecha_inicio', 'cursillos.fecha_final', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            'cursillos.esSolicitud')
            ->leftJoin('comunidades', 'cursillos.comunidad_id', '=', 'comunidades.id')
            ->ComunidadCursillos($comunidad)
            ->FiltroComunidadCursillosTipo(false)
            ->FiltroAnyosCursillos($anyo)
            ->FiltroEsRespuestaAnterior($incluirRespuestasAnteriores)
            ->Where('cursillos.activo', true)
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();
    }

    static public function obtenerComunidadesCursillosPDF($cursillos = Array())
    {
        return Cursillos::select('comunidades.id AS comunidad_id', 'comunidades.comunidad', 'tipos_secretariados.tipo_secretariado',
            'comunidades.direccion', 'paises.pais', 'provincias.provincia', 'localidades.localidad', 'comunidades.cp',
            'comunidades.email_solicitud', 'comunidades.email_envio', 'comunidades.direccion_postal', 'tipos_comunicaciones_preferidas.comunicacion_preferida',
            'cursillos.id as curso_id', 'cursillos.num_cursillo', 'cursillos.cursillo', 'cursillos.esRespuesta', 'cursillos.esSolicitud',
            'cursillos.fecha_inicio', 'cursillos.fecha_final', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'))
            ->leftJoin('comunidades', 'cursillos.comunidad_id', '=', 'comunidades.id')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->leftJoin('tipos_comunicaciones_preferidas', 'comunidades.tipo_comunicacion_preferida_id',
                '=', 'tipos_comunicaciones_preferidas.id')
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->FiltrarCursillos($cursillos)
            ->Where('comunidades.activo', true)
            ->Where('cursillos.activo', true)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();
    }

    static public function getTodosMisCursillos($comunidad = 0, $anyo = 0, $esSolicitudAnterior = 0)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'), 'comunidades.comunidad', 'comunidades.colorFondo',
            'comunidades.colorTexto', 'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->ComunidadCursillos($comunidad)
            ->FiltroAnyosCursillos($anyo)
            ->FilterEsSolicitudAnterior($esSolicitudAnterior)
            ->where('cursillos.activo', true)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'DESC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    static public function getTodosLosCursillosMenosLosMios($comunidadesDestinatarias = Array(), $anyo = 0, $esRespuestaAnterior = false, $tipoComunicacion = 0)
    {
        return Cursillos::Select('cursillos.id AS cursilloId', 'cursillos.cursillo', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'), 'comunidades.comunidad', 'comunidades.colorFondo',
            'comunidades.colorTexto', 'comunidades.email_envio', 'comunidades.id AS comunidadId', 'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->where('comunidades.activo', true)
            ->where('comunidades.espropia', false)
            ->FiltroComunidadesDestinatarias($comunidadesDestinatarias)
            ->FiltroAnyosCursillos($anyo)
            ->FiltroEsRespuestaAnterior($esRespuestaAnterior)
            ->FiltroComunidadCursillosTipoComunicacion($tipoComunicacion)
            ->where('cursillos.activo', true)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'DESC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    //Método para usar con comunidades propias y no propias
    static public function getTodosLosCursillosMenosLosMiosDobleComunidad($comunidadPropia = 0, $comunidadNoPropia = 0, $anyo = 0, $semana = 0)
    {
        return Cursillos::Select('cursillos.cursillo', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'), 'comunidades.comunidad', 'comunidades.colorFondo',
            'comunidades.colorTexto', 'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->where('comunidades.activo', true)
            ->ComunidadCursillosMenosLosMios($comunidadPropia)
            ->FiltroComunidadesDestinatarias($comunidadNoPropia)
            ->FiltroAnyosCursillos($anyo)
            ->SemanasCursillos($semana)
            ->where('cursillos.activo', true)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('semana', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    static public function getTodosMisCursillosLista($comunidad = 0, $esLista = false)
    {
        if ($comunidad == 0) {
            return;
        }
        $result = null;
        if (!$esLista) {
            $result = Cursillos::Select('cursillos.cursillo', 'cursillos.id')
                ->ComunidadCursillos($comunidad)
                ->where('cursillos.activo', true)
                ->orderBy('cursillos.fecha_inicio', 'DESC')
                ->orderBy('cursillos.cursillo', 'ASC')
                ->get();
        } else {
            $result = Cursillos::Select('cursillos.cursillo', 'cursillos.id')
                ->ComunidadCursillos($comunidad)
                ->where('cursillos.activo', true)
                ->orderBy('cursillos.fecha_inicio', 'DESC')
                ->orderBy('cursillos.cursillo', 'ASC')
                ->Lists('cursillos.cursillo', 'cursillos.id');
        }
        return $result;
    }

    static public function getTodosMisAnyosCursillosList($comunidad = 0, $conPlaceHolder = true, $placeHolder = "Año...")
    {
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%Y") as anyos'))
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->ComunidadCursillos($comunidad)
            ->Where('cursillos.activo', true)
            ->distinct()
            ->Lists('anyos', 'anyos');
        return $conPlaceHolder ? ['0' => $placeHolder] + $sql : $sql;
    }

    static public function GetAnyosCursillosList($comunidadesIds = Array(), $incluirRespuestasAnteriores = false, $conPlaceHolder = true, $placeHolder = "Año...")
    {
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%Y") as anyos'))
            ->ComunidadesCursillos($comunidadesIds)
            ->FiltroEsRespuestaAnterior($incluirRespuestasAnteriores)
            ->Where('cursillos.activo', true)
            ->distinct()
            ->orderBy('anyos', 'DESC')
            ->Lists('anyos');
        return $conPlaceHolder ? ['0' => $placeHolder] + $sql : $sql;
    }

    static public function getCursillo($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el cursillo
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', 'cursillos.fecha_final',
            'cursillos.descripcion', 'cursillos.activo', 'cursillos.num_cursillo', 'cursillos.esRespuesta', 'cursillos.esSolicitud',
            'comunidades.comunidad', 'comunidades.colorFondo', 'comunidades.colorTexto', 'comunidades.esPropia',
            'tipos_participantes.tipo_participante', 'paises.pais')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
            ->where('cursillos.id', $id)
            ->first();
    }

    static public function getAnyoCursillosList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->where('cursillos.activo', true)
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? ['0' => $placeHolder] + $sql : $sql;
    }

    static public function getAnyosAnterioresCursillosList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $date = date("Y-m-d", mktime(0, 0, 0, 1, 1, date("Y")));
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->where('cursillos.activo', true)
            ->Where('cursillos.fecha_inicio', '<', $date)
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? ['0' => $placeHolder] + $sql : $sql;
    }


    static public function getSemanasCursillos($cursillosIds = Array(), $anyo = 0)
    {
        return Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas'))
            ->ComunidadesCursillos($cursillosIds)
            ->FiltroAnyosCursillos($anyo)
            ->where('cursillos.activo', true)
            ->groupBy('semanas')
            ->orderBy('semanas')
            ->get();
    }

    static public function getFechasInicioCursillos($anyo = 0, $cursillos = 0, $esMia = false)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana')
            , DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'))
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->FiltroComunidadCursillosTipo($esMia)
            ->ComunidadCursillos($cursillos)
            ->where('cursillos.activo', true)
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%Y")'), '=', $anyo)
            ->orderBy('cursillos.fecha_inicio')
            ->get();
    }

    static public function getNombreCursillo($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el cursillo
        return Cursillos::Select('cursillos.cursillo')
            ->where('cursillos.id', $id)
            ->first();
    }

    static public function borrarTablaCursillos($anyo = 0)
    {
        DB::transaction(function ($anyo) {

            DB::table('cursillos')->delete()
                ->where(DB::raw('DATE_FORMAT(_cursillos.fecha_final,"%Y")'), '=', $anyo);
        });
    }

    public function comunidades()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'comunidad_id');
    }

    public function participantes()
    {
        return $this->belongsTo('Palencia\Entities\TiposParticipante', 'tipo_participante_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes_enviadas()
    {
        return $this->hasMany("Palencia\Entities\SolicitudesEnviadasCursillos");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes_recibidas()
    {
        return $this->hasMany("Palencia\Entities\SolicitudesRecibidasCursillos");
    }

    public function scopeFilterEsSolicitudAnterior($query, $esSolicitudAnterior = false)
    {
        $esSolicitudAnterior = filter_var($esSolicitudAnterior, FILTER_VALIDATE_BOOLEAN);
        if (filter_var($esSolicitudAnterior, FILTER_VALIDATE_BOOLEAN) && !$esSolicitudAnterior) {
            $query->where('cursillos.esSolicitud', $esSolicitudAnterior);
        }
        return $query;
    }

    public function scopeFiltroEsRespuestaAnterior($query, $incluirRespuestasAnteriores)
    {
        if (!is_null($incluirRespuestasAnteriores)) {
            $query->where('cursillos.esRespuesta', filter_var($incluirRespuestasAnteriores, FILTER_VALIDATE_BOOLEAN));
        }
        return $query;
    }


    public function scopeFiltroComunidadCursillosTipo($query, $tipo = false)
    {
        $tipo = filter_var($tipo, FILTER_VALIDATE_BOOLEAN);
        $query->where('comunidades.esPropia', $tipo);
        return $query;
    }

    public function scopeFiltroComunidadCursillosTipoComunicacion($query, $tipo = 0)
    {
        if (is_numeric($tipo) && $tipo > 0) {
            $query->where('comunidades.tipo_comunicacion_preferida_id', $tipo);
        }
        return $query;
    }

    public function scopeFiltroAnyosCursillos($query, $anyo = 0, $cursillo = 0)
    {
        if (is_numeric($anyo) && $anyo > 0 && $cursillo == 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%Y")'), '=', $anyo);
        }
        return $query;
    }

    public function scopeSemanasCursillos($query, $semana = 0)
    {
        if (is_numeric($semana) && $semana > 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v")'), $semana);
        }
        return $query;
    }

    public function scopeInicioCursillos($query, $cursilloId = 0)
    {
        if (is_numeric($cursilloId) && $cursilloId > 0) {
            $query->where('cursillos.id', $cursilloId);
        }
        return $query;
    }

    public function scopeComunidadCursillos($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {
            $query->where('cursillos.comunidad_id', $comunidadId);
        }
        return $query;
    }

    public function scopeComunidadesCursillos($query, $comunidadesIds = Array())
    {
        return $query->whereIn('cursillos.comunidad_id', $comunidadesIds);
    }


    public function scopeComunidadCursillosMenosLosMios($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {
            $query->where('cursillos.comunidad_id', '<>', $comunidadId)
                ->where('comunidades.espropia', true);
        }
        return $query;
    }

    public function scopeFiltroComunidadesDestinatarias($query, $restoComunidades = Array())
    {
        $query->WhereIn('cursillos.comunidad_id', $restoComunidades);
    }

    public function scopeFiltroComunidadesDestinatariasMultiple($query, $comunidadId = 0)
    {
        $comparador = (is_numeric($comunidadId) && $comunidadId > 0) ? "=" : "<>";
        return $query->orWhere('cursillos.comunidad_id', $comparador, $comunidadId)
            ->where('comunidades.espropia', false);
    }

    public function scopeCursilloId($query, $cursilloId = 0)
    {
        if (is_numeric($cursilloId) && $cursilloId > 0) {
            $query->where('cursillos.id', $cursilloId);
        }
        return $query;
    }

    public function scopeCursillo($query, $cursillo)
    {
        if (trim($cursillo) != '')
            $query->where('cursillo', 'LIKE', "$cursillo" . '%');
    }

    public function scopeFiltrarCursillos($query, $cursillos = Array())
    {
        return $query->whereIn('cursillos.id', $cursillos);
    }

    public function scopeCursilloEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('cursillos.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }

    public function scopeFiltroNombreComunidad($query, $comunidad = "")
    {
        if (trim($comunidad) != '')
            $query->where('comunidades.comunidad', 'LIKE', "$comunidad" . '%');
    }
}