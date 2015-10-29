<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cursillos extends Model
{

    protected $tabla = "cursillos";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public function comunidades()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'comunidad_id');
    }

    public function participantes()
    {
        return $this->belongsTo('Palencia\Entities\TiposParticipante', 'tipo_participante_id');
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

    public function scopeComunidadCursillos($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {
            $query->where('cursillos.comunidad_id', $comunidadId);
        }
        return $query;
    }

    public function scopeCursillo($query, $cursillo)
    {
        if (trim($cursillo) != '')
            $query->where('cursillo', 'LIKE', "$cursillo" . '%');
    }

    static public function getCalendarCursillos(Request $request)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio',
            'cursillos.fecha_final', 'comunidades.comunidad', 'comunidades.color')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    static public function getCursillos(Request $request)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio',
            'cursillos.activo', 'comunidades.comunidad', 'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->Cursillo($request->get('cursillo'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->paginate(5)
            ->setPath('cursillos');
    }

    static public function getTodosMisCursillos($comunidad = 0, $anyo = 0, $semana = 0)
    {
        return Cursillos::Select('cursillos.cursillo', 'cursillos.fecha_inicio',DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semana'),
            'comunidades.comunidad','comunidades.color', 'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->ComunidadCursillos($comunidad)
            ->AnyosCursillos($anyo)
            ->SemanasCursillos($semana)
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('semana', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }

    static public function getCursillo($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el cursillo
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', 'cursillos.fecha_final',
            'cursillos.descripcion', 'cursillos.activo', 'comunidades.comunidad', 'cursillos.num_cursillo',
            'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->where('cursillos.id', $id)
            ->first();
    }

    static public function getAnyoCursillosList($conPlaceHolder = true, $placeHolder = "Año...")
    {
        $placeHolder = ['0' => $placeHolder];
        $sql = Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
            ->groupBy('Anyos')
            ->orderBy('Anyos')
            ->Lists('Anyos', 'Anyos');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }

    static public function getSemanasCursillos($anyo = 0, $cursillos = 0)
    {

        return Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas'))
            ->ComunidadCursillos($cursillos)
            ->groupBy('semanas')
            ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->orderBy('semanas')
            ->get();
    }
}