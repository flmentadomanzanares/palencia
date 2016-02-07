<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Roles;
use Palencia\Entities\User;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesUsers;


//Se incluye las reglas de validación

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!auth()->check())
            return View("/");
        if (\Auth::user()->roles->peso < config('opciones.roles.administrador')) {
            $titulo = "Mi perfil";
            $users = User::getUser($request);
        } else {
            $titulo = "Usuarios";
            $users = User::getUsers($request);
        }
        $roles = Roles::getRolesList();
        return view("usuarios.index", compact('users', 'titulo', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar Usuario";
        $usuario = User::find($id);
        if ($usuario == null) {
            return Redirect('usuarios')->with('mensaje', 'No se encuentra el usuario seleccionado.');
        }
        $roles = Roles::orderBy('rol', 'ASC')
            ->lists('rol', 'id');
        return view('usuarios.modificar', compact('usuario', 'roles', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesUsers $request)
    {
        $user = User::find($id);
        if ($user == null) {
            return Redirect('usuarios')->with('mensaje', 'No se encuentra el usuario seleccionado.');
        }
        $user->fullname = \Request::input('fullname');
        $user->name = \Request::input('name');
        $user->password = strlen(\Request::input('password')) > 0 ? \Hash::make(\Request::input('password')) : $user->password;
        if (\Auth::check()) {
            if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
                $user->rol_id = \Request::input('rol_id');
                $user->activo = \Request::input('activo');
            }
        }
        //imagen upload
        if (\Request::hasFile('foto')) {
            $image = \Image::make(\Request::file('foto'));
            $filename = md5($image->filename . date("Y-m-d H:i:s")) . '.png';
            $path = 'uploads' . '/' . 'usuarios' . '/';
            // encode image to png
            $image->encode('png');
            // save resize
            $image->resize(180, 180);
            $image->save($path . $filename);
            $user->foto = $filename;
        }
        try {
            $user->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route('usuarios.index')
                        ->with('mensaje', 'Modificar Perfil error ' . $e->getMessage());
            }
        }
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            return redirect()->route('usuarios.index')
                ->with('mensaje', 'El Perfil ' . $user->name . ' ha sido modificado.');
        } else {
            return redirect()->route('inicio')
                ->with('mensaje', 'El Perfil de usuario ha sido modificado.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return Redirect('usuarios')->with('mensaje', 'No se encuentra el usuario seleccionado.');
        }
        $userNombre = $user->name;
        try {
            $user->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('usuarios.index')
                        ->with('mensaje', 'El usuario ' . $userNombre . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()
                        ->route('usuarios.index')->with('mensaje', 'Eliminar usuario error ' . $e->getCode());
            }

        }

        return redirect()->route('usuarios.index')
            ->with('mensaje', 'El usuario ' . $userNombre . ' eliminado correctamente.');
    }

    public function perfil()
    {
        $titulo = "Modificar Usuario";
        $usuario = User::find(\Auth::user()->id);
        if ($usuario == null) {
            return Redirect('usuarios')->with('mensaje', 'No se encuentra el usuario seleccionado.');
        }
        $roles = Roles::orderBy('rol', 'ASC')
            ->lists('rol', 'id');
        return view('usuarios.modificar', compact('usuario', 'roles', 'titulo'));
    }

}
