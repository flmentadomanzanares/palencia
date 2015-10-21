<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TiposComunicacionesPreferidas extends Model {

    protected $tabla="tipos_comunicaciones_preferidas";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cursillosTipoComunicacionesPreferidas(){
        return $this->hasMany("Palencia\Entities\Comunidades");
    }
    public static function getTipoComunicacionesPreferidasList()
    {
        return ['0' => 'Comunicación...'] + TiposComunicacionesPreferidas::Select('id', 'comunicacion_preferida')
            ->where('activo', true)
            ->orderBy('comunicacion_preferida', 'ASC')
            ->Lists('comunicacion_preferida', 'id');
    }
    static public function getTiposComunicacionesPreferidas(Request $request){
        return TiposComunicacionesPreferidas::Select('id','comunicacion_preferida')
            ->tipoComunicacionesPreferidas($request->get('comunicacion_preferida'))
            ->orderBy('comunicacion_preferida', 'ASC')
            ->paginate()
            ->setPath('tiposComunicacionesPreferidas');
    }
    /**
     * @param $query
     * @param $pais
     */
    public function scopeTipoComunicacionesPreferidas($query,$comunicacion_preferida){
        if (trim($comunicacion_preferida)!='')
            $query->where('comunicacion_preferida','LIKE',"$comunicacion_preferida".'%');
    }

}
