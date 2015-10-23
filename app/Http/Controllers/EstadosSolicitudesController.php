<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\Colores;
use Palencia\Entities\EstadosSolicitudes;
use Palencia\Http\Requests;
use Illuminate\Http\Request;

//Validación
use Palencia\Http\Requests\ValidateRulesEstadosSolicitudes;

class EstadosSolicitudesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Estados de las solicitudes";
        $estados_solicitudes = EstadosSolicitudes::getEstadosSolicitudes($request);
        return view("estadosSolicitudes.index", compact('estados_solicitudes', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo estado de solicitud";
        $estados_solicitudes = new estadosSolicitudes();
        $colors = Colores::getColores();
        return view('estadosSolicitudes.nuevo', compact('estados_solicitudes', 'colors', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesEstadosSolicitudes $request)
    {
        $estados_solicitudes = new estadosSolicitudes(); //Creamos instancia al modelo
        $estados_solicitudes->estado_solicitud = \Request::input('estado_solicitud'); //Asignamos el valor al campo.
        $estados_solicitudes->color = \Request::input('color');
        try {
            $estados_solicitudes->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('estadosSolicitudes.create')
                        ->with('mensaje', 'El estado de solicitud está ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('estadosSolicitudes.index')
                        ->with('mensaje', 'Nuevo estado de solicitud error ' . $e->getCode());
            }
        }
        return redirect('estadosSolicitudes')
            ->with('mensaje', 'El estado de solicitud se ha  creado satisfactoriamente . ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar tipo de cursillo";
        $estados_solicitudes = estadosSolicitudes::find($id);
        $colors =  $colors = Colores::getColores();
        return view('estadosSolicitudes.modificar', compact('estados_solicitudes', 'colors', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesEstadosSolicitudes $request)
    {
        $estados_solicitudes = estadosSolicitudes::find($id);
        $estados_solicitudes->estado_solicitud = \Request::input('estado_solicitud');
        $estados_solicitudes->color = \Request::input('color');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $estados_solicitudes->activo = \Request::input('activo');
        }
        try {
            $estados_solicitudes->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('estadosSolicitudes.index')
                        ->with('mensaje', 'Modificar estado de solicitud error ' . $e->getMessage());
            }
        }
        return redirect()->route('estadosSolicitudes.index')
            ->with('mensaje', 'El estado de solicitud se ha modificado satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $estados_solicitudes = estadosSolicitudes::find($id);
        $cursillo = $estados_solicitudes->cursillo;
        try {
            $estados_solicitudes->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('estadosSolicitudes.index')
                        ->with('mensaje', 'El estado de solicitud no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('estadosSolicitudes.index')
                        ->with('mensaje', 'Eliminar estado solicitud error ' . $e->getCode());
            }
        }
        return redirect()->route('estadosSolicitudes.index')
            ->with('mensaje', 'El estado de solicitud se ha eliminado correctamente.');
    }
}
