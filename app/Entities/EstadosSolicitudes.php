<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class EstadosSolicitudes extends Model {

    protected $tabla="estados_solicitudes";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    static public function getEstadosSolicitudesList()
    {
        return ['0' => 'Estados...'] + EstadosSolicitudes::Select('id', 'estado_solicitud')
            ->where('activo', true)
            ->orderBy('estado_solicitud', 'ASC')
            ->Lists('estado_solicitud', 'id');
    }

    static public function getEstadosSolicitudes(Request $request){
        return EstadosSolicitudes::Select('id','estado_solicitud','color')
            ->EstadoSolicitud($request->get('estado_solicitud'))
            ->orderBy('estado_solicitud', 'ASC')
            ->paginate()
            ->setPath('estadosSolicitudes');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function solicitudes(){
        return $this->hasMany("Palencia\Entities\Solicitudes");
    }

    /**
     * @param $query
     * @param $pais
     */
    public function scopeEstadoSolicitud($query,$estadoSolicitud){
        if (trim($estadoSolicitud)!='')
            $query->where('estado_solicitud','LIKE',"$estadoSolicitud".'%');
    }

}
