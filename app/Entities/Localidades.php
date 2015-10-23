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
            ->Lists('localidad', 'id');
    }

    public static function getLocalidades(Request $request)
    {
        return Localidades::select('paises.pais', 'provincias.provincia', 'localidades.localidad', 'localidades.id')->
        leftJoin('provincias', 'provincias.id', '=', 'localidades.provincia_id')->
        leftJoin('paises', 'paises.id', '=', 'provincias.pais_id')->
        pais($request->get('pais'))->
        provincia($request->get('provincia'))->
        localidad($request->get('localidad'))->
        orderBy('pais', 'ASC')->
        orderBy('provincia', 'ASC')->
        orderBy('localidad', 'ASC')->
        paginate()->
        setPath('localidades');
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

