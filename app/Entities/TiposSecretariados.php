<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class TiposSecretariados extends Model {

    protected $tabla="tipos_secretariados";
    protected $fillable=['secretariado']; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoSecretariado(){
        return $this->hasMany("Palencia\Entities\Cursillos");
    }

    public static function getTiposSecretariadosList()
    {
        return ['0' => 'Secretariado...'] + TiposSecretariados::Select('id', 'tipo_secretariado')
            ->where('activo', true)
            ->orderBy('tipo_secretariado', 'ASC')
            ->Lists('tipo_secretariado', 'id');
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoSecretariado($query,$tipoSecretariado){
        if (trim($tipoSecretariado)!='')
            $query->where('secretariado','LIKE',"$tipoSecretariado".'%');
    }

}
