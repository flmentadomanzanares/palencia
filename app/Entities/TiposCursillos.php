<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class TiposCursillos extends Model {

    protected $tabla="tipos_cursillos";
    protected $fillable=['cursillo']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoCursillo(){
        return $this->hasMany("Palencia\Entities\Cursillos");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoCursillo($query,$tipoCursillo){
        if (trim($tipoCursillo)!='')
            $query->where('cursillo','LIKE',"$tipoCursillo".'%');
    }

}
