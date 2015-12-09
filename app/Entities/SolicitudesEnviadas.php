<?php namespace Palencia\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesEnviadas extends Model {

    protected $tabla = "solicitudes_enviadas";
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

    public function scopeCursilloSolicitudesEnviadas($query, $cursilloId = 0)
    {
        if (is_numeric($cursilloId) && $cursilloId > 0) {
            $query->where('solicitudes_enviadas.cursillo_id', $cursilloId);
        }
        return $query;
    }

    static public function getSolicitudesEnviadas(Request $request)
    {
        return SolicitudesEnviadas::Select('solicitudes_enviadas.id', 'comunidades.comunidad', 'cursillos.cursillo',
            'solicitudes_enviadas.cursillo_id', 'cursillos.fecha_inicio', 'solicitudes_enviadas.activo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
            ->AnyosCursillos($request->get('anyos'))
            ->SemanasCursillos($request->get('semanas'))
            ->CursilloSolicitudesEnviadas($request->get('cursillo'))
            ->orderBy('cursillos.fecha_inicio', 'ASC')
            ->orderBy('comunidades.comunidad', 'ASC')
            ->orderBy('cursillos.cursillo', 'ASC')
            ->paginate(5)
            ->setPath('solicitudesEnviadas');

    }


    static public function imprimirIntendenciaClausura($fecha_inicio = null, $fecha_final = null)
    {

         return SolicitudesEnviadas::Select('paises.pais', 'comunidades.comunidad', 'cursillos.cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
            ->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('solicitudes_enviadas.activo', true)
            ->where('cursillos.fecha_inicio', '>', $fecha_inicio)
            ->orWhere('cursillos.fecha_inicio', '=', $fecha_inicio)
            ->where('cursillos.fecha_final', '<', $fecha_final)
            ->orWhere('cursillos.fecha_final', '=', $fecha_final)
            ->orderBy('cursillos.cursillo', 'ASC')
            ->orderBy('paises.pais', 'ASC')
            ->orderBy('comunidades.comunidad', 'ASC')
            ->get();

    }

    static public function getSolicitudesComunidad($comunidadId=0)
    {

        return SolicitudesEnviadas::Select('cursillos.fecha_inicio', 'cursillos.cursillo')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
            ->where('solicitudes_enviadas.aceptada', true)
            ->where('solicitudes_enviadas.activo', true)
            ->where('comunidades.id', '=', $comunidadId)
            ->orderBy('comunidades.comunidad')
            ->orderBy('cursillos.cursillo')
            ->get();

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

}
