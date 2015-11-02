<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesRecibidas extends Model {

    protected $tabla = "solicitudes_recibidas";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

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
        return SolicitudesRecibidas::Select('solicitudes_recibidas.id', 'comunidades.comunidad','cursillos.cursillo',
            'cursillos.fecha_inicio', 'solicitudes_recibidas.activo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_recibidas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_recibidas.cursillo_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->paginate(5)
            ->setPath('solicitudesRecibidas');

    }
}
