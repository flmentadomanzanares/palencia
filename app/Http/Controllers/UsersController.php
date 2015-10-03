<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;

use Illuminate\Http\Request;


use Palencia\Entities\User;
use Palencia\Entities\Roles;

//Se incluye las reglas de validación
use Palencia\Http\Requests\ValidateRulesUsers;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "";
        //Vamos al indice y creamos una paginación de 8 elementos y con ruta usuarios
        if (\Auth::check()) {
            if (\Auth::user()->roles->peso < config('opciones.roles.administrador')) {
                $titulo = "Mi perfil";
                $users = User::where('id', '=', \Auth::user()->id)->get(); //Obtiene un único registro
            } else {
                $titulo = "Listado de Usuarios";

                $users = $request->get('campo') != null || $request->get('rol') != null ?
                    User::fields($request->get('campo'), $request->get('value'))->roles($request->get('rol'), $request->get('campo'))->paginate(5)->setPath('usuarios')
                    :
                    User::orderBy('fullname', 'ASC')->paginate(5)->setPath('usuarios');
            }
        } else {
            $users = User::where('id', -1)->get();
        }
        $roles =['0'=>'Elige Rol']+ Roles::where('peso', '>', 0)->orderBy('rol', 'ASC')->lists('rol', 'id');

        return view("usuarios.index", compact('users','titulo','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $user = new User;
        return view('usuarios.nuevo', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea categorías vacías. con store()
    public function store(ValidateRulesUsers $request)
    {
        $user = new User; //Creamos instancia al modelo

        $user->categoria = \Request::input('categoria'); //Asignamos el valor al campo.
        try {
            $user->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('usuarios.create')->with('mensaje', 'La categoría ' . \Request::input('categoria') . ' está ya dada de alta.');
                    break;
                default:
                    return redirect()->route('usuarios.index')->with('mensaje', 'Nueva categoría error ' . $e->getCode());
            }
        }
        return redirect('usuarios')->with('mensaje', 'La categoría ' . $user->categoria . ' creada satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $roles = Roles::orderBy('rol', 'ASC')->lists('rol','id');
        return view('usuarios.modificar')->with('usuario', User::find($id))->with('roles', $roles)->with('titulo', 'Modificar Perfíl');
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
                    return redirect()->route('usuarios.index')->with('mensaje', 'Modificar Perfil error ' . $e->getMessage());
            }
        }
        return redirect()->route('usuarios.index')->with('mensaje', 'El Perfil ' . $user->name . ' ha sido modificado.');
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
        $userNombre = $user->name;
        try {
            $user->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('usuarios.index')->with('mensaje', 'El usuario ' . $userNombre . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('usuarios.index')->with('mensaje', 'Eliminar usuario error ' . $e->getCode());
            }

        }

        return redirect()->route('usuarios.index')->with('mensaje', 'El usuario ' . $userNombre . ' eliminado correctamente.');
    }

}
