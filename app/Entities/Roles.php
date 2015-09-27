<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

    protected $tabla = "roles";
    protected $fillable = ['rol', 'peso']; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public function scopeRol($query, $rol)
    {
        if (trim($rol) != '')
            $query->where('rol', 'LIKE', "$rol" . '%');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany("Palencia\Entities\User");
    }


}
