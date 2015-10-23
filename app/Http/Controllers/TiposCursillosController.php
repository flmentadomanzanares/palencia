<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\Colores;
use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\tiposCursillos;

//Validación
use Palencia\Http\Requests\ValidateRulesTiposCursillos;

class TiposCursillosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de tipos de cursillos";
        $tipos_cursillos = TiposCursillos::getTiposCursillos($request);
        return view("tiposCursillos.index", compact('tipos_cursillos', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo tipo de cursillo";
        $tipos_cursillos = new tiposCursillos();
        $colors = Colores::getColores();
        return view('tiposCursillos.nuevo', compact('tipos_cursillos', 'colors', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposCursillos $request)
    {
        $tipos_cursillos = new tiposCursillos(); //Creamos instancia al modelo
        $tipos_cursillos->tipo_cursillo = \Request::input('tipo_cursillo'); //Asignamos el valor al campo.
        $tipos_cursillos->color = \Request::input('color');
        try {
            $tipos_cursillos->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposCursillos.create')
                        ->with('mensaje', 'El tipo de cursillo ' . \Request::input('cursillo') . ' está ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('tiposCursillos.index')
                        ->with('mensaje', 'Nuevo tipo de cursillo error ' . $e->getCode());
            }
        }
        return redirect('tiposCursillos')
            ->with('mensaje', 'El tipo de cursillo ' . $tipos_cursillos->cursillo . ' creado satisfactoriamente . ');

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
        $tipos_cursillos = tiposCursillos::find($id);
        $colors =  $colors = Colores::getColores();
        return view('tiposCursillos.modificar', compact('tipos_cursillos', 'colors', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposCursillos $request)
    {
        $tipos_cursillos = tiposCursillos::find($id);
        $tipos_cursillos->tipo_cursillo = \Request::input('tipo_cursillo');
        $tipos_cursillos->color = \Request::input('color');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipos_cursillos->activo = \Request::input('activo');
        }
        try {
            $tipos_cursillos->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposCursillos.index')
                        ->with('mensaje', 'Modificar tipo cursillo error ' . $e->getMessage());
            }
        }
        return redirect()->route('tiposCursillos.index')
            ->with('mensaje', 'El tipo de cursillo se ha modificado satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipos_cursillos = tiposCursillos::find($id);
        $cursillo = $tipos_cursillos->cursillo;
        try {
            $tipos_cursillos->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposCursillos.index')
                        ->with('mensaje', 'El tipo de cursillo ' . $cursillo . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('tiposCursillos.index')
                        ->with('mensaje', 'Eliminar tipo cursillo error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposCursillos.index')
            ->with('mensaje', 'El tipo de cursillo se ha eliminado correctamente.');
    }
}
