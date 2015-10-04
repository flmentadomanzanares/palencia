<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class TiposParticipantes extends Model {

    protected $tabla="tipos_participantes";
    protected $fillable=['participante']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

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
    public function scopeTiposParticipantes($query,$tipoParticipante){
        if (trim($tipoParticipante)!='')
            $query->where('tipo_participantes','LIKE',"$tipoParticipante".'%');
    }

}
