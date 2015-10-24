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

    public function cursillos()
    {
        return $this->belongsTo('Palencia\Entities\TiposCursillos', 'tipo_cursillo_id');
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
            $query->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v")') ,'like', $semana);
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
            'cursillos.fecha_final','comunidades.comunidad','tipos_cursillos.color')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('tipos_cursillos', 'tipos_cursillos.id', '=', 'cursillos.tipo_cursillo_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->get();
    }
    static public function getCursillos(Request $request)
    {
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio',
            'cursillos.activo', 'comunidades.comunidad', 'tipos_cursillos.tipo_cursillo',
            'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('tipos_cursillos', 'tipos_cursillos.id', '=', 'cursillos.tipo_cursillo_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->paginate(5)
            ->setPath('cursillos');
    }

    static public function getCursillo($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el cursillo
        return Cursillos::Select('cursillos.id', 'cursillos.cursillo', 'cursillos.fecha_inicio', 'cursillos.fecha_final',
            'cursillos.descripcion', 'cursillos.activo', 'comunidades.comunidad', 'tipos_cursillos.tipo_cursillo',
            'cursillos.num_cursillo', 'tipos_participantes.tipo_participante')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_participantes', 'tipos_participantes.id', '=', 'cursillos.tipo_participante_id')
            ->leftJoin('tipos_cursillos', 'tipos_cursillos.id', '=', 'cursillos.tipo_cursillo_id')
            ->where('cursillos.id', $id)
            ->first();
    }

    static public function getAnyoCursillos()
    {
       return ['0' => 'Año...'] + Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x") as Anyos'))
                ->groupBy('Anyos')
                ->orderBy('Anyos')
                ->Lists('Anyos', 'Anyos');
    }
    static public function getSemanasCursillos($anyo=0)
    {
         return Cursillos::Select(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%v") as semanas'))
            ->groupBy('semanas')
             ->where(DB::raw('DATE_FORMAT(cursillos.fecha_inicio,"%x")'), '=', $anyo)
            ->orderBy('semanas')
            ->get();
    }

    // Listado cursillos en el mundo
    static public function getCursillosPorPaises()
    {

       return Cursillos::Select('cursillos.*', 'comunidades.id', 'comunidades.pais_id', 'tipos_cursillos.id', 'tipos_cursillos.tipo_cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->leftJoin('tipos_cursillos', 'tipos_cursillos.id', '=', 'cursillos.tipo_cursillo_id')
            ->where('tipos_cursillos.tipo_cursillo', '!=', 'Interno')
            ->orderBy('comunidades.pais_id', 'ASC')
           ->orderBy('cursillos.fecha_inicio', 'ASC')
           ->get();

    }

}