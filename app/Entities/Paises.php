<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
    public static function getPaisesList()
    {
        return ['0' => 'País...'] + Paises::Select('id', 'pais')
            ->where('activo', true)
            ->orderBy('pais', 'ASC')
            ->Lists('pais', 'id');
    }

    public static function getPaisesAll($id)
    {
        return Paises::with('provincias')->
        join('provincias','pais_id','=','paises.id')->
        select('paises.pais','paises.id')->
        where('provincias.id',$id)->
        lists('pais','id');
    }
    /**
     * @param $query
     * @param $pais
     */
    public function scopePais($query,$pais){
        if (trim($pais)!='')
            $query->where('pais','LIKE',"$pais".'%');
    }

    public static function getPaises(Request $request){

        return Paises::pais($request->get('pais'))
            ->orderBy('pais', 'ASC')
            ->paginate(4)
            ->setPath('paises');
    }

    static public function getNombrePais($id = null)
    {
        if (!is_numeric($id))
            return null;
        //Obtenemos el pais
        return Paises::Select('paises.pais')
            ->where('paises.id', $id)
            ->first();
    }
}
