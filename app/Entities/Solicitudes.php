<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Solicitudes extends Model {
    protected $tabla="solicitudes";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    static public function getSolicitudes(Request $request){
       dd( Solicitudes::Select('solicitudes.id','solicitudes.fecha_envio','solicitudes.activo',
            'solicitudes.fecha_respuesta','comunidades.comunidad','cursillos.cursillo',
            'tipos_comunicaciones_preferidas.comunicacion_preferida'
            ,'estados_solicitudes.estado_solicitud','estados_solicitudes.color')
            ->leftJoin('comunidades', 'comunidades.id', '=', 'solicitudes.comunidad_id')
            ->leftJoin('estados_solicitudes', 'estados_solicitudes.id', '=', 'solicitudes.estado_solicitud_id')
            ->orderBy('tipo_cursillo', 'ASC')
            ->paginate()
            ->setPath('tiposCursillos'));
    }

}
