<?php namespace Palencia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Roles extends Model
{

    protected $tabla = "roles";
    protected $fillable = ['rol', 'peso']; //Campos a usar
    protected $guarded = ['id']; //Campos no se usan

    public static function getRoles(Request $request, $paginateNumber = 25)
    {

        return Roles::rol($request->get('rol'))
            ->RolEsActivo($request->get('esActivo'))
            ->orderBy('rol', 'ASC')
            ->paginate($paginateNumber)
            ->setPath('roles');
    }

    public static function getRolesList($placeholder = "Roles...")
    {
        return ['0' => $placeholder] + Roles::where('peso', '>', 0)
            ->orderBy('rol', 'ASC')
                ->lists('rol', 'id')->toArray();
    }

    public function scopeRol($query, $rol)
    {
        if (trim($rol) != '')
            $query->where('rol', 'LIKE', "$rol" . '%');
    }

    public function scopeRolEsActivo($query, $esActivo)
    {
        if (is_numeric($esActivo)) {
            $query->where('roles.activo', filter_var($esActivo, FILTER_VALIDATE_BOOLEAN));
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany("Palencia\Entities\User");
    }
}
