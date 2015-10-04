<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class TiposParticipantes extends Model {

    protected $tabla="tipos_participantes";
    protected $fillable=['participante']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoParticipantes(){
        return $this->hasMany("Palencia\Entities\Cursillos");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoParticipante($query,$tipoParticipante){
        if (trim($tipoParticipante)!='')
            $query->where('participante','LIKE',"$tipoParticipante".'%');
    }

}
