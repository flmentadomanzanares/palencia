<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class TiposComunidades extends Model {

    protected $tabla="tipos_comunidades";
    protected $fillable=['comunidad']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoComunidades(){
        return $this->hasMany("Palencia\Entities\Cursillos");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoComunidad($query,$tipoComunidad){
        if (trim($tipoComunidad)!='')
            $query->where('comunidad','LIKE',"$tipoComunidad".'%');
    }

}
