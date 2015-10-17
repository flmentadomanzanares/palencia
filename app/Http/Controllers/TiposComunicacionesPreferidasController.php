<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\TiposComunicacionesPreferidas;

//Validación
use Palencia\Http\Requests\ValidateRulesTiposComunicacionesPreferidas;

class TiposComunicacionesPreferidasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de tipos de comunicaciones preferidas";
        $tipos_comunicaciones_preferidas =
            TiposComunicacionesPreferidas::getTiposComunicacionesPreferidas($request);

        return view("tiposComunicacionesPreferidas.index", compact('tipos_comunicaciones_preferidas', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo tipo de comunicacion_preferida";
        $tipos_comunicaciones_preferidas = new TiposComunicacionesPreferidas();
        return view('tiposComunicacionesPreferidas.nuevo', compact('tipos_comunicaciones_preferidas', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposComunicacionesPreferidas $request)
    {
        $tipos_comunicaciones_preferidas = new TiposComunicacionesPreferidas(); //Creamos instancia al modelo
        $tipos_comunicaciones_preferidas->comunicacion_preferida = \Request::input('comunicacion_preferida'); //Asignamos el valor al campo.
        try {
            $tipos_comunicaciones_preferidas->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposComunicacionesPreferidas.create')
                        ->with('mensaje', 'El tipo de comunicacion preferida ' . \Request::input('comunicacion_preferida') . ' está ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'Nueva comunicación preferida error ' . $e->getCode());
            }
        }
        return redirect('tiposComunicacionesPreferidas')
            ->with('mensaje', 'El tipo de comunicacion preferida ' . $tipos_comunicaciones_preferidas->comunicacion_preferida . ' creado satisfactoriamente . ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar tipo de comunicacion preferida";
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::find($id);
        return view('tiposComunicacionesPreferidas.modificar', compact('tipos_comunicaciones_preferidas', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposComunicacionesPreferidas $request)
    {
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::find($id);
        $tipos_comunicaciones_preferidas->comunicacion_preferida = \Request::input('comunicacion_preferida');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipos_comunicaciones_preferidas->activo = \Request::input('activo');
        }
        try {
            $tipos_comunicaciones_preferidas->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'Modificar tipo comunicacion preferida error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposComunicacionesPreferidas.index')
            ->with('mensaje', 'El tipo de comunicacion preferida se ha modificado satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::find($id);
        $comunicacion_preferida = $tipos_comunicaciones_preferidas->comunicacion_preferida;
        try {
            $tipos_comunicaciones_preferidas->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'El tipo de comunicacion preferida ' . $comunicacion_preferida . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'Eliminar tipo comunicacion preferida error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposComunicacionesPreferidas.index')
            ->with('mensaje', 'El tipo de comunicacion preferida se ha eliminado correctamente.');
    }
}
