<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Provincias extends Model
{

    protected $tabla = "provincias";
    protected $fillable = ['provincia']; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public static function getProvinciaDesdeLocalidad($provinciaId = 0)
    {
        if (is_numeric($provinciaId) && $provinciaId > 0) {
            return Provincias::Select('id', 'provincia')
                ->where('id', $provinciaId)
                ->Lists('provincia', 'id');
        }
        return array();
    }

    public static function getProvinciasDesdePais($pais = 0)
    {
        if (is_numeric($pais) && $pais > 0) {
            return Provincias::Select('id', 'provincia')
                ->where('pais_id', $pais)
                ->Lists('provincia', 'id');
        }
        return array();
    }

    public static function getPaisDesdeProvincia($provinciaId = 0)
    {
        if (is_numeric($provinciaId) && $provinciaId > 0) {
            return Provincias::Select('paises.id', 'paises.pais')
                ->Where('provincias.id', $provinciaId)
                ->leftJoin('paises', 'paises.id', '=', 'provincias.pais_id')
                ->Lists('paises.pais', 'paises.id');
        }
        return array();
    }

    public static function getProvinciasList()
    {
        return ['0' => 'Provincia...'] + Provincias::Select('id', 'provincia')
            ->where('activo', true)
            ->orderBy('provincia', 'ASC')
            ->Lists('provincia', 'id');
    }

    public static function getProvinciaToList($id)
    {
        return Provincias::where('id', $id)->
        lists('provincia', 'id');
    }

    public static function getProvincias(Request $request, $paginateNumber = 25)
    {
        return Provincias::pais($request->get('pais'))->
        provincia($request->get('provincia'))->
        ProvinciaEsActivo($request->get('esActivo'))->
        orderBy('provincia', 'ASC')->
        paginate($paginateNumber)->
        setPath('provincias');
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopePais($query, $pais)
    {
        if (is_numeric($pais)) {
            if ($pais > 0)
                $query->where('pais_id', $pais);
            else
                $query->where('pais_id', '>', $pais);
        }
    }

    /**
     * @param $query
     * @param $provincia
     */
    public function scopeProvincia($query, $provincia)
    {
        if (trim($provincia) != '')
            $query->where('provincia', 'LIKE', "$provincia" . '%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function localidades()
    {
        return $this->hasMany("Palencia\Entities\Localidades");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comunidades()
    {
        return $this->hasMany("Palencia\Entities\Comunidades");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paises()
    {
        return $this->belongsTo('Palencia\Entities\Paises', 'pais_id');
    }

    public function scopeProvinciaEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('provincias.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }
}
