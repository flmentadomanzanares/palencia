<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Roles;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesRoles;

//Validación


class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de Roles";

        //Vamos al indice y creamos una paginación de 3 elementos y con ruta categorias
        $roles = Roles::getRoles($request);
        return view("roles.index", compact("roles", "titulo"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo Rol";
        $rol = new Roles();
        return view("roles.nuevo", compact("rol", "titulo"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea roles vacíos. con store()
    public function store(ValidateRulesRoles $request)
    {
        $rol = new Roles(); //Creamos instancia al modelo

        $rol->rol = $request->get('rol'); //Asignamos el valor al campo.
        $rol->peso = $request->get('peso'); //Asignamos el valor al campo.

        try {
            $rol->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('roles.create')
                        ->with('mensaje', 'El rol ' . $rol->rol . ' está ya dado de alta.');
                    break;
                default:
                    return redirect()->route('roles.index')
                        ->with('mensaje', 'Nuevo rol error ' . $e->getCode());
            }
        }
        return redirect('roles')
            ->with('mensaje', 'El rol ' . $rol->rol . ' se ha creado satisfactoriamente.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar Rol";
        $rol = Roles::find($id);
        if ($rol == null) {
            return Redirect('roles')->with('mensaje', 'No se encuentra el rol seleccionado.');
        }
        return view('roles.modificar', compact('rol', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesRoles $request)
    {
        $rol = Roles::find($id);
        if ($rol == null) {
            return Redirect('roles')->with('mensaje', 'No se encuentra el rol seleccionado.');
        }
        $rol->rol = $request->get('rol');
        $rol->peso = $request->get('peso');
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $rol->activo = $request->get('activo');
        }
        try {
            $rol->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route('roles.index')
                        ->with('mensaje', 'Modificar rol error ' . $e->getCode());
            }
        }
        return redirect()->route('roles.index')
            ->with('mensaje', 'roles ' . $rol->rol . ' ha sido modificado correctamente ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $rol = Roles::find($id);
        if ($rol == null) {
            return Redirect('roles')->with('mensaje', 'No se encuentra el rol seleccionado.');
        }
        try {
            $rol->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('roles.index')
                        ->with('mensaje', 'El rol ' . $rol->rol . ' no se puede eliminar al tener usuarios asociados.');
                    break;
                default:
                    return redirect()->route('roles.index')
                        ->with('mensaje', 'Eliminar rol error ' . $e->getCode());
            }

        }
        return redirect()->route('roles.index')->with('mensaje', 'El rol ' . $rol->rol . ' se ha eliminado correctamente.');
    }
}