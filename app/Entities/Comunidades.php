<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Comunidades extends Model
{

    protected $tabla = "comunidades";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    static public function getComunidades(Request $request)
    {
        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'comunidades.responsable', 'comunidades.direccion',
            'comunidades.esColaborador', 'comunidades.esPropia', 'comunidades.color', 'comunidades.activo', 'tipos_comunicaciones_preferidas.comunicacion_preferida',
            'tipos_secretariados.tipo_secretariado', 'paises.pais', 'provincias.provincia', 'localidades.localidad')
            ->EsPropia($request->esPropia)
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->TipoSecretariado($request->get('secretariado'))
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->Paises($request->get('pais'))
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->Comunidades($request->get('comunidad'))
            ->leftJoin('tipos_comunicaciones_preferidas', 'comunidades.tipo_comunicacion_preferida_id', '=', 'tipos_comunicaciones_preferidas.id')
            ->orderBy('comunidad', 'ASC')
            ->paginate(5)
            ->setPath('comunidades');
    }

    static public function getComunidadPDF($comunidad = 0, $esPropia = null, $excluirSinCursillos = false)
    {

        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'tipos_secretariados.tipo_secretariado',
            'comunidades.direccion', 'paises.pais', 'provincias.provincia', 'localidades.localidad', 'comunidades.cp',
            'comunidades.email_solicitud', 'comunidades.email_envio', 'comunidades.direccion_postal', 'tipos_comunicaciones_preferidas.comunicacion_preferida')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->leftJoin('tipos_comunicaciones_preferidas', 'comunidades.tipo_comunicacion_preferida_id',
                '=', 'tipos_comunicaciones_preferidas.id')
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->leftJoin(DB::raw("(SELECT COUNT(cursillos.comunidad_id) as cursillosTotales ,cursillos.comunidad_id as cursilloId
                        FROM cursillos, comunidades
                        WHERE comunidades.id = cursillos.comunidad_id
                        GROUP BY cursillos.comunidad_id
            ) cursillos"), "comunidades.id", "=", 'cursilloId')
            ->ExcluirSinCursillos($excluirSinCursillos)
            ->ComunidadesId($comunidad)
            ->esPropia($esPropia)
            ->orderBy("comunidades.comunidad")
            ->get();
    }

    static public function getComunidad($id = null)
    {
        if (!is_numeric($id))
            return null;
        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'comunidades.esPropia', 'comunidades.color',
            'tipos_secretariados.tipo_secretariado', 'comunidades.responsable', 'comunidades.direccion', 'paises.pais',
            'provincias.provincia', 'localidades.localidad', 'comunidades.cp', 'comunidades.email_solicitud',
            'comunidades.direccion_postal', 'comunidades.email_envio', 'comunidades.web', 'comunidades.facebook',
            'comunidades.telefono1', 'comunidades.telefono2', 'tipos_comunicaciones_preferidas.comunicacion_preferida',
            'comunidades.observaciones', 'comunidades.esColaborador', 'comunidades.activo')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->leftJoin('tipos_comunicaciones_preferidas', 'comunidades.tipo_comunicacion_preferida_id',
                '=', 'tipos_comunicaciones_preferidas.id')
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->where('comunidades.id', $id)
            ->first();
    }

    static public function getComunidadConCursilloId($id = null)
    {
        if (!is_numeric($id))
            return null;
        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'comunidades.esPropia')
            ->leftJoin('cursillos', 'comunidades.id', '=', 'cursillos.comunidad_id')
            ->where('cursillos.id', $id)
            ->get();
    }

    public static function getComunidadesList($propia = null, $conPlaceHolder = true, $placeHolder = "Comunidad...", $excluirSinCursillos = false)
    {
        $placeHolder = ['0' => $placeHolder];
        if (!$excluirSinCursillos) {
            $sql = Comunidades::Select('id', 'comunidad')
                ->where('activo', true)
                ->EsPropia($propia)
                ->orderBy('comunidad', 'ASC')
                ->Lists('comunidad', 'id');
        } else {
            $sql = Comunidades::Select('comunidades.id', 'comunidades.comunidad')
                ->where('comunidades.activo', true)
                ->EsPropia($propia)
                ->leftJoin(DB::raw("(SELECT COUNT(cursillos.comunidad_id) as cursillosTotales ,cursillos.comunidad_id as cursilloId
                        FROM cursillos, comunidades
                        WHERE comunidades.id = cursillos.comunidad_id AND cursillos.esRespuesta = false
                        GROUP BY cursillos.comunidad_id
            ) cursillos"), "comunidades.id", "=", 'cursilloId')
                ->Where('cursillosTotales', '>', 0)
                ->orderBy('comunidades.comunidad', 'ASC')
                ->Lists('comunidades.comunidad', 'comunidades.id');
        }
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }

    static public function imprimirSecretariadosPais($pais = 0)
    {

        return Comunidades::Select('comunidades.comunidad')
            ->where('comunidades.pais_id', '=', $pais)
            ->where('comunidades.esColaborador', true)
            ->where('comunidades.activo', true)
            ->orderBy('comunidades.comunidad')
            ->get();

    }

    static public function imprimirSecretariadosNoColaboradores($pais)
    {

        if ($pais == 0) {

            return Comunidades::Select('comunidades.comunidad', 'paises.pais')
                ->leftJoin('paises', 'paises.id', '=', 'comunidades.pais_id')
                ->where('comunidades.esColaborador', false)
                ->where('comunidades.activo', true)
                ->orderBy('paises.pais')
                ->orderBy('comunidades.comunidad')
                ->get();

        } else {

            return Comunidades::Select('comunidades.comunidad')
                ->where('comunidades.pais_id', '=', $pais)
                ->where('comunidades.esColaborador', false)
                ->where('comunidades.activo', true)
                ->orderBy('comunidades.comunidad')
                ->get();

        }

    }

    public static function getComunidadesAll()
    {
        return ['0' => 'Secretariado...'] + Comunidades::Select('id', 'comunidad')
            ->where('activo', true)
            ->orderBy('comunidad', 'ASC')
            ->Lists('comunidad', 'id');
    }

    static public function getNombreComunidad($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos la comunidad
        return Comunidades::Select('comunidades.comunidad', 'comunidades.color')
            ->where('comunidades.id', $id)
            ->first();
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: tipo_comunidad --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function tipo_secretariado()
    {
        return $this->belongsTo('App\TiposSecretariados', 'tipo_secretariado_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: tipo_comunidad --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function tipo_comunicacion_preferida()
    {
        return $this->belongsTo('App\TiposComunicacionesPreferidas', 'tipo_comunicacion_preferida_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: paises --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function paises()
    {
        return $this->belongsTo('App\Paises', 'pais_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: provincias --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function provincias()
    {
        return $this->belongsTo('App\Provincias', 'provincia_id');
    }

    /*****************************************************************************************************************
     *
     * Relacion many to one: localidades --> comunidades
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     *****************************************************************************************************************/
    public function localidades()
    {
        return $this->belongsTo('App\Localidades', 'localidad_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes_enviadas()
    {

        return $this->hasMany("Palencia\Entities\SolicitudesEnviadas");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes_recibidas()
    {
        return $this->hasMany("Palencia\Entities\SolicitudesRecibidas");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes_enviadas_cursillos()
     {

         return $this->hasMany("Palencia\Entities\SolicitudesEnviadasCursillos");
     }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes_recibidas_cursillos()
     {
            return $this->hasMany("Palencia\Entities\SolicitudesRecibidasCursillos");
     }

    public function scopeComunidades($query, $comunidad = null)
    {
        if ($comunidad != null && trim($comunidad) != '') {
            $query->where('comunidades.comunidad', 'LIKE', "$comunidad" . '%');
        }
        return $query;
    }

    public function scopeComunidadesId($query, $comunidadId = 0)
    {
        if (is_numeric($comunidadId) && $comunidadId > 0) {
            $query->where('comunidades.id', $comunidadId);
        }
        return $query;
    }

    public function scopeEsColaborador($query, $esColaborador = null)
    {
        if (is_bool($esColaborador)) {
            $query->where('comunidades.esColaborador', $esColaborador);
        }
        return $query;
    }

    public function scopeEsPropia($query, $esPropia = null)
    {
        if (is_numeric($esPropia)) {
            $query->where('comunidades.esPropia', $esPropia == 1 ? true : false);
        }
        return $query;
    }

    public function scopeExcluirSinCursillos($query, $excluirSinCursillos = false)
    {

        if ($excluirSinCursillos) {
            $query->where('cursillosTotales', '>', 0);
        }
        return $query;
    }
    public function scopeTipoSecretariado($query, $secretariado = 0)
    {
        if (is_numeric($secretariado) && $secretariado > 0) {
            $query->where('tipos_secretariados.id', '=', $secretariado);
        }
        return $query;
    }

    public function scopePaises($query, $pais = 0)
    {
        if (is_numeric($pais) && $pais > 0) {
            $query->where('paises.id', '=', $pais);
        }
        return $query;
    }

    public function scopeFiltroComunidades($query, Request $request)
    {
        foreach ($request->all() as $idx => $val) {
            if (Schema::hasColumn('comunidades', $idx) && $val != null && trim($val) != '') {
                if (is_numeric($val))
                    $query->where($idx, $val);
                else
                    $query->where($idx, 'LIKE', "$val" . '%');
            }
        }
        return $query;
    }
}


