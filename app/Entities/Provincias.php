<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model {

    protected $tabla="provincias";
    protected $fillable=['provincia']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

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
    public function scopeProvincia($query,$provincia){
        if (trim($provincia)!='')
            $query->where('provincia','LIKE',"$provincia".'%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function localidades(){
        return $this->hasMany("Palencia\Entities\Localidades");
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
    public function paises()
    {
        return $this->belongsTo('Palencia\Entities\Paises', 'pais_id');
    }

}
