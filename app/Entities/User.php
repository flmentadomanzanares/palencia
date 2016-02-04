<?php namespace Palencia\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

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
    protected $fillable = ['fullname', 'name', 'email', 'foto', 'password', 'activo', 'confirmado', 'codigo_confirmacion'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function getUser(Request $request)
    {

        return User::where('id', '=', \Auth::user()->id)
            ->get();                                    //Obtiene un único registro
    }

    public static function getUsers(Request $request)
    {

        return $request->get('campo') != null || $request->get('rol') != null ?
            User::fields($request->get('campo'), $request->get('value'))
                ->roles($request->get('rol'), $request->get('campo'))->paginate(5)->setPath('usuarios')
            :
            User::orderBy('fullname', 'ASC')
                ->paginate(5)
                ->setPath('usuarios');
    }

    /**
     * @param $query referencia a nuestra query
     * @param $user
     */
    public function scopeRoles($query, $rol, $campo)
    {
        switch ($campo) {
            case 'fullname':
            case 'name':
            case 'email':
                break;
            default :
                $campo = 'fullname';
        }
        if (is_numeric($rol)) {
            if ($rol > 0)
                $query->where('rol_id', $rol)->orderBy($campo, 'ASC');
            else
                $query->where('rol_id', '>', $rol)->orderBy($campo, 'ASC');
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
                $campo = substr($campo, 1);
                $value = '0';
        }

        if (trim($value) != '') {
            $query->where($campo, 'LIKE', $value . '%');

        }

    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();
        // Check if the user is a root account
        if ($this->have_role->rol == 'administrador') {
            return true;
        }
        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }

    //ROLES
    //*********************************************************************************************************

    private function getUserRole()
    {
        return $this->roles()->getResults();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roles()
    {
        return $this->belongsTo('Palencia\Entities\Roles', 'rol_id');
    }

    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role) == strtolower($this->have_role->name)) ? true : false;
    }
}