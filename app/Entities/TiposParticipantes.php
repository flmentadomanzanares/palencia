<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TiposParticipantes extends Model {

    protected $tabla="tipos_participantes";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoParticipantes(){
        return $this->hasMany("Palencia\Entities\Cursillos");
    }
    static public function getTiposParticipantes(Request $request)
    {
        return TiposParticipantes::Select('id','tipo_participante','activo')
            ->tipoParticipante($request->get('tipo_participante'))
            ->orderBy('tipo_participante', 'ASC')
            ->paginate(10)
            ->setPath('tiposParticipantes');
    }
    static public function getTiposParticipantesList()
    {
        return ['0' => 'Asistentes...'] + TiposParticipantes::Select('id', 'tipo_participante')
            ->where('activo', true)
            ->orderBy('tipo_participante', 'ASC')
            ->Lists('tipo_participante', 'id');
    }
    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoParticipante($query,$tipoParticipante){
        if (trim($tipoParticipante)!='')
            $query->where('tipo_participante','LIKE',"$tipoParticipante".'%');
    }

}
