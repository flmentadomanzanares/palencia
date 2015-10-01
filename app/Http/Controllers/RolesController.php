<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Palencia\Entities\Roles;

//Validación
use Palencia\Http\Requests\ValidateRulesRoles;


class RolesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //Vamos al indice y creamos una paginación de 3 elementos y con ruta roles
        $roles = Roles::rol($request->get('rol'))->orderBy('rol', 'ASC')->paginate(3)->setPath('roles');
        return view("roles.index", compact('roles'))->with('titulo', 'Listado de Roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = new Roles;
        return view('roles.nuevo')->with('roles', $roles)->with('titulo', 'Nuevo Rol');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea roles vacíos. con store()
    public function store(ValidateRulesRoles $request)
    {
        $roles = new Roles; //Creamos instancia al modelo

        $roles->rol = \Request::input('rol'); //Asignamos el valor al campo.
        $roles->peso = \Request::input('peso'); //Asignamos el valor al campo.

        try {
            $roles->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('roles.create')->with('mensaje', 'El rol ' . \Request::input('rol') . ' está ya dado de alta.');
                    break;
                default:
                    return redirect()->route('roles.index')->with('mensaje', 'Nuevo rol error ' . $e->getCode());
            }
        }
        return redirect('roles')->with('mensaje', 'El rol ' . $roles->rol . ' creado satisfactoriamente.');

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
        return view('roles.modificar')->with('roles', Roles::find($id))->with('titulo', 'Modificar Rol');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesRoles $request)
    {
        $roles = Roles::find($id);
        $nombreRol = $roles->rol;
        $roles->rol = \Request::input('rol');
        $roles->peso = \Request::input('peso');
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $roles->activo = \Request::input('activo');
        }
        try {
            $roles->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route('roles.index')->with('mensaje', 'Modificar rol error ' . $e->getCode());
            }
        }
        return redirect()->route('roles.index')->with('mensaje', 'roles ' . $nombreRol . ' ha sido modificado correctamente ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $roles = Roles::find($id);
        $rolNombre = $roles->rol;
        try {
            $roles->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('roles.index')->with('mensaje', 'El rol ' . $rolNombre . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('roles.index')->with('mensaje', 'Eliminar rol error ' . $e->getCode());
            }

        }

        return redirect()->route('roles.index')->with('mensaje', 'El rol ' . $rolNombre . ' eliminado correctamente.');
    }

}