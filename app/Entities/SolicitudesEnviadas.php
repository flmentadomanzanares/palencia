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
  * Relacion one to many: solicitud_id_id --> solicitudes_enviadas
  *
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  *
  *****************************************************************************************************************/
    public function solicitudes_enviadas_cursillos()
    {

        return $this->hasMany("Palencia\Entities\SolicitudesEnviadasCursillos");
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

    static public function getSolicitudesEnviadas(Request $request)
    {
        return SolicitudesEnviadas::Select('solicitudes_enviadas.id', 'comunidades.comunidad','solicitudes_enviadas.aceptada',
            'solicitudes_enviadas.activo', 'solicitudes_enviadas.created_at', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->ComunidadSolicitudesEnviadas($request->get('comunidades'))
            ->orderBy('solicitudes_enviadas.id', 'ASC')
            ->paginate(5)
            ->setPath('solicitudesEnviadas');

    }

    static public function imprimirIntendenciaClausura($fecha_inicio = null, $fecha_final = null)
    {

         return SolicitudesEnviadas::distinct()->Select('paises.pais', 'comunidades.comunidad')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes_enviadas.comunidad_id')
            ->leftJoin('cursillos', 'cursillos.id', '=', 'solicitudes_enviadas.cursillo_id')
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
}
