<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Localidades extends Model
{
    protected $tabla = "localidades";
    protected $fillable = ['localidad']; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public static function getLocalidadesList()
    {
        return ['0' => 'Localidad...'] + Localidades::Select('id', 'localidad')
            ->where('activo', true)
            ->orderBy('localidad', 'ASC')
                ->Lists('localidad', 'id')->toArray();
    }

    public static function getLocalidadToList($id)
    {
        return Localidades::where('id', $id)->
        lists('localidad', 'id');
    }

    public static function getLocalidades(Request $request, $paginateNumber = 25)
    {
        return Localidades::select('paises.pais', 'provincias.provincia', 'localidades.localidad', 'localidades.id', 'localidades.activo')->
        leftJoin('provincias', 'provincias.id', '=', 'localidades.provincia_id')->
        leftJoin('paises', 'paises.id', '=', 'provincias.pais_id')->
        pais($request->get('pais'))->
        provincia($request->get('provincias'))->
        localidad($request->get('localidad'))->
        LocalidadEsActivo($request->get('esActivo'))->
        orderBy('localidad', 'ASC')->
        orderBy('pais', 'ASC')->
        orderBy('provincia', 'ASC')->
        paginate($paginateNumber)->
        setPath('localidades');
    }

    public static function getLocalidad($id)
    {

        return Localidades::select('localidades.*', 'provincias.provincia', 'paises.pais')->
        leftjoin('provincias', 'provincias.id', '=', 'localidades.provincia_id')->
        leftjoin('paises', 'paises.id', '=', 'provincias.pais_id')->
        where('localidades.id', $id)->
        first();
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
        if (is_numeric($provincia)) {
            if ($provincia > 0)
                $query->where('provincia_id', $provincia);
            else
                $query->where('provincia_id', '>', $provincia);
        }
    }

    /**
     * @param $query
     * @param $localidad
     */
    public function scopeLocalidad($query, $localidad)
    {
        if (trim($localidad) != '')
            $query->where('localidad', 'LIKE', "$localidad" . '%');
    }

    public function scopeLocalidadEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('localidades.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
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
    public function provincias()
    {
        return $this->belongsTo('Palencia\Entities\Provincias', 'provincia_id');
    }

}

