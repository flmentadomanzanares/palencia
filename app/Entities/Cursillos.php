<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cursillos extends Model {

    protected $tabla="cursillos";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    public function comunidades()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'comunidad_id');
    }
    public function cursillos()
    {
        return $this->belongsTo('Palencia\Entities\TiposCursillos', 'tipo_cursillo_id');
    }
    public function participantes()
    {
        return $this->belongsTo('Palencia\Entities\TiposParticipante', 'tipo_participante_id');
    }

    public function scopeCursillo($query, $cursillo)
    {
        if (trim($cursillo) != '')
            $query->where('cursillo', 'LIKE', "$cursillo" . '%');
    }

}
