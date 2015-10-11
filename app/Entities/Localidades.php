<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Localidades extends Model {

    protected $tabla="localidades";
    protected $fillable=['localidad']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    public static function getLocalidadesList()
    {
        return ['0' => 'Localidad...'] + Localidades::Select('id', 'localidad')
            ->where('activo', true)
            ->orderBy('localidad', 'ASC')
            ->Lists('localidad', 'id');
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
    public function scopeLocalidad($query,$localidad){
        if (trim($localidad)!='')
            $query->where('localidad','LIKE',"$localidad".'%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comunidades(){
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

