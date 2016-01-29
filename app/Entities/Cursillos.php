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
            'cursillos.fecha_final', 'comunidades.comunidad', 'comunidades.color')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->FiltroComunidadCursillosTipo($request->get('esPropia'))
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
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

    static public function getCursillos(Request $request)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', 'comunidades.color',
            'cursillos.activo', 'comunidades.comunidad', 'comunidades.esPropia', 'cursillos.num_cursillo', 'cursillos.esRespuesta',
            'cursillos.esSolicitud', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->ComunidadCursillos($request->get('comunidad'))
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->Cursillo($request->get('cursillo'))
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'DESC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->paginate(5)
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
        DB::transaction(function () use (&$recordsCount, $cursillosIds) {
            $ids = implode(",", $cursillosIds);
            $recordsCount = DB::update("update cursillos set esSolicitud=true  where (esSolicitud = false and activo = true and id in ($ids))");
        });
        return $recordsCount;
    }

    static public function setCursillosEsRespuesta($cursillosIds = array())
    {
        $recordsCount = 0;
        DB::transaction(function () use (&$recordsCount, $cursillosIds) {
            $ids = implode(",", $cursillosIds);
            $recordsCount = DB::update("update cursillos set esRespuesta=true  where (esRespuesta = false and activo = true and id in ($ids))");

        });
        return $recordsCount;
    }

    /**
     * @param int $comunidad
     * @param int $anyo
     * @param int $incluirSolicitudesAnteriores
     * @return mixed
     */
    static public function getCursillosPDFSolicitud($comunidad = 0, $anyo = 0, $incluirSolicitudesAnteriores = 0)
    {
        return Cursillos::select('cursillos.id', 'cursillos.comunidad_id', 'cursillos.num_cursillo', 'cursillos.cursillo', 'cursillos.esRespuesta',
            'cursillos.fecha_inicio', 'cursillos.fecha_final', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            'cursillos.esSolicitud')
            ->leftJoin('comunidades', 'cursillos.comunidad_id', '=', 'comunidades.id')
            ->ComunidadCursillos($comunidad)
            ->AnyosCursillos($anyo)
            ->FilterEsSolicitudAnterior($incluirSolicitudesAnteriores)
            ->Where('cursillos.activo', true)
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();
    }

    static public function getCursillosPDFRespuesta($comunidad = 0, $anyo = 0, $incluirRespuestasAnteriores = 0)
    {
        return Cursillos::select('cursillos.id', 'cursillos.comunidad_id', 'cursillos.num_cursillo', 'cursillos.cursillo', 'cursillos.esRespuesta',
            'cursillos.fecha_inicio', 'cursillos.fecha_final', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            'cursillos.esSolicitud')
            ->leftJoin('comunidades', 'cursillos.comunidad_id', '=', 'comunidades.id')
            ->ComunidadCursillos($comunidad)
            ->FiltroComunidadCursillosTipo(0)
            ->AnyosCursillos($anyo)
            ->FilterEsRespuestaAnterior($incluirRespuestasAnteriores)
            ->Where('cursillos.activo', true)
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->get();
    }

    static public function getTodosMisCursillos($comunidad = 0, $anyo = 0, $esSolicitudAnterior = 0)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'), 'comunidades.comunidad', 'comunidades.color', 'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->ComunidadCursillos($comunidad)
            ->AnyosCursillos($anyo)
            ->FilterEsSolicitudAnterior($esSolicitudAnterior)
            ->where('cursillos.activo', true)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    static public function getTodosLosCursillosMenosLosMios($comunidad = 0, $anyo = 0, $esRespuestaAnterior = 0)
    {
        return Cursillos::Select('cursillos.cursillo', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'), 'comunidades.comunidad', 'comunidades.color',
            'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->where('comunidades.activo', true)
            ->ComunidadCursillosResto($comunidad)
            ->AnyosCursillos($anyo)
            ->FilterEsRespuestaAnterior($esRespuestaAnterior)
            ->where('cursillos.activo', true)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    //Método para usar con comunidades propias y no propias
    static public function getTodosLosCursillosMenosLosMiosDobleComunidad($comunidadPropia = 0, $comunidadNoPropia = 0, $anyo = 0, $semana = 0)
    {
        return Cursillos::Select('cursillos.cursillo', 'cursillos.fecha_inicio', DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as anyo'), 'comunidades.comunidad', 'comunidades.color',
            'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->where('comunidades.activo', true)
            ->ComunidadCursillosMenosLosMios($comunidadPropia)
            ->ComunidadCursillosResto($comunidadNoPropia)
            ->AnyosCursillos($anyo)
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
                ->orderBy('cursillos.fecha_inicio')
                ->orderBy('cursillos.cursillo', 'ASC')
                ->get();
        } else {
            $result = Cursillos::Select('cursillos.cursillo', 'cursillos.id')
                ->ComunidadCursillos($comunidad)
                ->where('cursillos.activo', true)
                ->orderBy('cursillos.fecha_inicio')
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

    static public function getCursillo($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el cursillo
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', 'cursillos.fecha_final',
            'cursillos.descripcion', 'cursillos.activo', 'cursillos.num_cursillo', 'cursillos.esRespuesta', 'cursillos.esSolicitud',
            'comunidades.comunidad', 'comunidades.color', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->where('cursillos.id', $id)
            ->first();
    }

    static public function getAnyoCursillosList($comunidad = array(), $conPlaceHolder = true, $placeHolder = "Año...")
    {
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->where('cursillos.activo', true)
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? ['0' => $placeHolder] + $sql : $sql;
    }

    static public function getSemanasCursillos($anyo = 0, $cursillos = 0)
    {
        return Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas'))
            ->ComunidadCursillos($cursillos)
            ->where('cursillos.activo', true)
            ->groupBy('semanas')
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->orderBy('semanas')
            ->get();
    }

    static public function getFechasInicioCursillos($anyo = 0, $cursillos = 0, $esMia = 0)
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

    public function scopeFilterEsSolicitudAnterior($query, $esSolicitudAnterior = 0)
    {
        if (is_numeric($esSolicitudAnterior) && $esSolicitudAnterior == 1) {
            $query->where('cursillos.esSolicitud', !$esSolicitudAnterior);
        }
        return $query;
    }

    public function scopeFilterEsRespuestaAnterior($query, $esRespuestaAnterior = 0)
    {
        if (is_numeric($esRespuestaAnterior) && $esRespuestaAnterior == 1) {
            $query->where('cursillos.esRespuesta', !$esRespuestaAnterior);
        }
        return $query;
    }

    public function scopeFiltroComunidadCursillosTipo($query, $tipo = 0)
    {
        if (is_numeric($tipo)) {
            $query->where('comunidades.esPropia', $tipo);
        }
        return $query;
    }

    public function scopeAnyosCursillos($query, $anyo = 0, $cursillo = 0)
    {
        if (is_numeric($anyo) && $anyo > 0 && $cursillo == 0) {
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%Y")'), '=', $anyo);
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

    public function scopeComunidadCursillosMenosLosMios($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {
            $query->where('cursillos.comunidad_id', '<>', $comunidadId)
                ->where('comunidades.espropia', true);
        }
        return $query;
    }

    public function scopeComunidadCursillosResto($query, $comunidadId = 0)
    {
        $comparador = (is_numeric($comunidadId) && $comunidadId > 0) ? "=" : "<>";
        return $query->Where('cursillos.comunidad_id', $comparador, $comunidadId)
            ->where('comunidades.espropia', false);
    }

    public function scopeComunidadCursillosRestoMultiple($query, $comunidadId = 0)
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

    static public function borrarTablaCursillos($anyo = 0)
    {
        DB::transaction(function($anyo) {

            DB::table('cursillos')->delete()
                ->where(DB::raw('DATE_FORMAT(_cursillos.fecha_final,"%Y")'), '=', $anyo);
        });
    }
}