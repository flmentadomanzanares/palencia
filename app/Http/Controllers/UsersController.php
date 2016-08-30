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
        $titulo = (\Auth::user()->roles->peso < config('opciones.roles.administrador')) ? "Mi perfil" : "Usuarios";
        $users = User::getUsers($request);
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
        $user->fullname = $request->get('fullname');
        $user->name = $request->get('name');
        $user->password = strlen($request->get('password')) > 0 ? \Hash::make($request->get('password')) : $user->password;
        if (\Auth::check()) {
            if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
                $user->rol_id = $request->get('rol_id');
                $user->activo = $request->get('activo');
            }
        }

        //imagen upload
        if ($request->hasFile('foto')) {
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
                ->with('mensaje', 'El Perfil ' . $user->name . ' ha sido modificado correctamente.');
        } else {
            return redirect()->route('inicio')
                ->with('mensaje', 'El Perfil de usuario ' . $user->name . ' ha sido modificado correctamente.');
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

        try {
            if ($user->roles->peso >= config('opciones.roles.administrador') && (User::getNumberUserWithRol(config('opciones.roles.administrador'))) > 1) {
                $user->delete();
            } else {
                return redirect()->route('usuarios.index')
                    ->with('mensaje', 'No se puede eliminar al usuario ' . $user->name . ' es el &uacute;ltimo administrador activo.');
            }

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('usuarios.index')
                        ->with('mensaje', 'El usuario ' . $user->name . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()
                        ->route('usuarios.index')->with('mensaje', 'Eliminar usuario error ' . $e->getCode());
            }
        }
        return redirect()->route('usuarios.index')
            ->with('mensaje', 'El usuario ' . $user->name . ' se ha eliminado correctamente.');
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
