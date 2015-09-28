<?php namespace Palencia\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fullname', 'name', 'email', 'foto', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'codigo_confirmar'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roles()
    {
        return $this->belongsTo('Palencia\Entities\Roles', 'rol_id');
    }

    /**
     * @param $query referencia a nuestra query
     * @param $user
     */
    public function scopeRoles($query, $rol,$campo)
    {
        switch ($campo) {
            case 'fullname':
            case 'name':
            case 'email':
                break;
            default :
                $campo = 'fullname';
        }
        if (is_numeric($rol) ) {
            if ($rol>0)
                $query->where('rol_id',$rol)->orderBy($campo, 'ASC');
            else
                $query->where('rol_id','>',$rol)->orderBy($campo, 'ASC');
        }
    }

    /**
     * @param $query
     * @param $campo
     * @param $value
     */
    public function scopeFields($query, $campo, $value)
    {
        switch ($campo) {
            case 'confirmado':
            case 'activo':
                $value = '1';
                break;
            case 'nconfirmado':
            case 'nactivo':
                $campo = substr($campo,1);
                $value = '0';
        }

        if (trim($value) != '') {
            $query->where($campo, 'LIKE', $value . '%');

        }

    }


}