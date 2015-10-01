<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Cursillos extends Model {

    protected $tabla="cursillos";
    protected $fillable=[]; //Campos a usar
    protected $guarded =['id']; //Campos no se usan

    public function comunidades()
    {
        return $this->belongsTo('Palencia\Entities\Comunidades', 'comunidad_id');
    }

    public function scopeCursillo($query, $cursillo)
    {
        if (trim($cursillo) != '')
            $query->where('cursillo', 'LIKE', "$cursillo" . '%');
    }

}
