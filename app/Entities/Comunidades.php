<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


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
            'comunidades.esColaborador', 'comunidades.esPropia', 'comunidades.color', 'comunidades.activo',
            'tipos_secretariados.tipo_secretariado', 'paises.pais', 'provincias.provincia', 'localidades.localidad')
            ->EsPropia($request->esPropia)
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->TipoSecretariado($request->get('secretariado'))
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->Paises($request->get('pais'))
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->Comunidades($request->get('comunidad'))
            ->orderBy('comunidad', 'ASC')
            ->paginate(5)
            ->setPath('comunidades');
    }

    static public function getComunidad($id = null)
    {
        if (!is_numeric($id))
            return null;
        return Comunidades::Select('comunidades.id', 'comunidades.comunidad', 'comunidades.esPropia', 'comunidades.color',
            'tipos_secretariados.tipo_secretariado', 'comunidades.responsable', 'comunidades.direccion', 'paises.pais',
            'provincias.provincia', 'localidades.localidad', 'comunidades.cp', 'comunidades.email1', 'comunidades.email2',
            'comunidades.web', 'comunidades.facebook', 'comunidades.telefono1', 'comunidades.telefono2',
            'tipos_comunicaciones_preferidas.comunicacion_preferida', 'comunidades.observaciones',
            'comunidades.esColaborador', 'comunidades.activo')
            ->leftJoin('tipos_secretariados', 'comunidades.tipo_secretariado_id', '=', 'tipos_secretariados.id')
            ->leftJoin('tipos_comunicaciones_preferidas', 'comunidades.tipo_comunicacion_preferida_id',
                '=', 'tipos_comunicaciones_preferidas.id')
            ->leftJoin('paises', 'comunidades.pais_id', '=', 'paises.id')
            ->leftJoin('provincias', 'comunidades.provincia_id', '=', 'provincias.id')
            ->leftJoin('localidades', 'comunidades.localidad_id', '=', 'localidades.id')
            ->where('comunidades.id', $id)
            ->first();
    }

    public static function getComunidadesList($propia = null, $conPlaceHolder = true, $placeHolder = "Comunidad...")
    {
        $placeHolder = ['0' => $placeHolder];
        $sql = Comunidades::Select('id', 'comunidad')
            ->where('activo', true)
            ->EsPropia($propia)
            ->orderBy('comunidad', 'ASC')
            ->Lists('comunidad', 'id');
        return $conPlaceHolder ? $placeHolder + $sql : $sql;
    }

    public function scopeComunidades($query, $comunidad = null)
    {
        if ($comunidad != null && trim($comunidad) != '') {
            $query->where('comunidad', 'LIKE', "$comunidad" . '%');
        }
        return $query;
    }

    public function scopeEsColaborador($query, $esColaborador = null)
    {
        if (is_bool($esColaborador)) {
            $query->where('esColaborador', $esColaborador);
        }
        return $query;
    }

    public function scopeEsPropia($query, $esPropia = null)
    {
        if (is_bool($esPropia)) {
            $query->where('esPropia', $esPropia);
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


