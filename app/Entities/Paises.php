<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model {

    protected $tabla="paises";
    protected $fillable=['pais']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provincias(){
        return $this->hasMany("Palencia\Entities\Provincias");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comunidades(){
        return $this->hasMany("Palencia\Entities\Comunidades");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopePais($query,$pais){
        if (trim($pais)!='')
            $query->where('pais','LIKE',"$pais".'%');
    }

}
