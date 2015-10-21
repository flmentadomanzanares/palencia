<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TiposCursillos extends Model {

    protected $tabla="tipos_cursillos";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    static public function getTiposCursillosList()
    {
        return ['0' => 'Cursillos...'] + TiposCursillos::Select('id', 'tipo_cursillo')
            ->where('activo', true)
            ->orderBy('tipo_cursillo', 'ASC')
            ->Lists('tipo_cursillo', 'id');
    }

    static public function getTiposCursillos(Request $request){
        return TiposCursillos::Select('id','tipo_cursillo','color')
            ->tipoCursillo($request->get('tipo_cursillo'))
            ->orderBy('tipo_cursillo', 'ASC')
            ->paginate()
            ->setPath('tiposCursillos');
    }
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
            $query->where('tipo_cursillo','LIKE',"$tipoCursillo".'%');
    }

}
