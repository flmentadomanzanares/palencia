<?php namespace Palencia\Services;


use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Palencia\Entities\User;
use Validator;

class Registrar implements RegistrarContract
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'fullname' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    public function create(array $data)
    {
        return User::create([
            'fullname' => $data['fullname'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'activo' => $data['activo'],
            'confirmado' => $data['confirmado'],
            'codigo_confirmacion' => $data['codigo_confirmacion'],
        ]);
    }

}
