<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use PhpSpec\Exception\Exception;

class Comunidades extends Model
{

    protected $tabla = "comunidades";
    protected $fillable = []; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

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

    static public function getComunidades(Request $request)
    {
        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'comunidades.responsable', 'comunidades.direccion',
            'comunidades.activo', 'tipos_secretariados.secretariado', 'paises.pais', 'provincias.provincia', 'localidades.localidad')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->Comunidades($request->get('comunidad'))
            ->where('tipos_secretariados.activo', true)
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->Paises($request->get('pais'))
            ->where('paises.activo', true)
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->Provincias($request->get('provincia'))
            ->where('provincias.activo', true)
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->where('localidades.activo', true)
            ->orderBy('comunidad', 'ASC')
            ->paginate(5)
            ->setPath('comunidades');
    }

    static public function getComunidad($id)
    {
        if (!is_numeric($id))
            return null;
        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'tipos_secretariados.secretariado',
            'comunidades.responsable', 'comunidades.direccion', 'paises.pais', 'provincias.provincia', 'localidades.localidad',
            'comunidades.cp', 'comunidades.email1', 'comunidades.email2', 'comunidades.web', 'comunidades.facebook',
            'comunidades.telefono1', 'comunidades.telefono2', 'tipos_comunicaciones_preferidas.comunicacion_preferida',
            'comunidades.observaciones', 'comunidades.activo')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->where('tipos_secretariados.activo', true)
            ->leftJoin('tipos_comunicaciones_preferidas', 'comunidades.tipo_comunicacion_preferida_id',
                '=', 'tipos_comunicaciones_preferidas.id')
            ->where('tipos_comunicaciones_preferidas.activo', true)
            ->where('comunidades.id', $id)
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->where('paises.activo', true)
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->where('provincias.activo', true)
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->where('localidades.activo', true)
            ->orderBy('comunidad', 'ASC')
            ->where('comunidades.activo', true)
            ->first();
    }

    public static function getSecretariadosList()
    {
        return ['0' => 'Secretariado...'] + TiposSecretariados::Select('id', 'secretariado')
            ->where('activo', true)
            ->orderBy('secretariado', 'ASC')
            ->Lists('secretariado', 'id');
    }

    public static function getPaisesList()
    {
        return ['0' => 'País...'] + Paises::Select('id', 'pais')
            ->where('activo', true)
            ->orderBy('pais', 'ASC')
            ->Lists('pais', 'id');
    }

    public static function getProvinciasList()
    {
        return ['0' => 'Elige...'] + Provincias::Select('id', 'provincia')
            ->where('activo', true)
            ->orderBy('provincia', 'ASC')
            ->Lists('provincia', 'id');
    }

    public static function getLocalidadesList()
    {
        return ['0' => 'Elige...'] + Localidades::Select('id', 'localidad')
            ->where('activo', true)
            ->orderBy('localidad', 'ASC')
            ->Lists('localidad', 'id');
    }

    public static function getComunicacionesPreferidasList()
    {
        return ['0' => 'Elige...'] + TiposComunicacionesPreferidas::Select('id', 'comunicacion_preferida')
            ->where('activo', true)
            ->orderBy('comunicacion_preferida', 'ASC')
            ->Lists('comunicacion_preferida', 'id');
    }

    public function scopeComunidades($query, $comunidad = null)
    {
        if ($comunidad != null && trim($comunidad) != '') {
            $query->where('comunidades.comunidad', 'LIKE', "$comunidad" . '%');
        }
        return $query;
    }

    public function scopeSecretariados($query, $secretariado = null)
    {
        if (is_numeric($secretariado) && $secretariado > 0) {
            $query->where('tipos_secretariados.id', '=', $secretariado);
        }
        return $query;
    }

    public function scopePaises($query, $pais = null)
    {
        if (is_numeric($pais) && $pais > 0) {
            $query->where('paises.id', '=', $pais);
        }
        return $query;
    }

    public function scopeProvincias($query, $provincia = null)
    {
        if (is_numeric($provincia) && $provincia > 0) {
            $query->where('provincias.id', '=', $provincia);
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


