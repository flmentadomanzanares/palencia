<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\TiposSecretariados;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesTiposSecretariados;

//Validación

class TiposSecretariadosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Tipos de Secretariados";
        $tipos_secretariados = TiposSecretariados::getTipoSecretariados($request);
        return view("tiposSecretariados.index", compact('tipos_secretariados', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo tipo de secretariado";
        $tipos_secretariados = new tiposSecretariados();
        return view('tiposSecretariados.nuevo', compact('tipos_secretariados', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposSecretariados $request)
    {
        $tipos_secretariados = new tiposSecretariados(); //Creamos instancia al modelo
        $tipos_secretariados->tipo_secretariado = \Request::input('tipo_secretariado'); //Asignamos el valor al campo.
        try {
            $tipos_secretariados->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposSecretariados.create')
                        ->with('mensaje', 'El tipo de secretariado ' . \Request::input('secretariado') . ' está ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('tiposSecretariados.index')
                        ->with('mensaje', 'Nuevo tipo de secretariado error ' . $e->getCode());
            }
        }
        return redirect('tiposSecretariados')
            ->with('mensaje', 'El tipo de secretariado ha sido creado satisfactoriamente . ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar tipo de secretariado";
        $tipos_secretariados = tiposSecretariados::find($id);
        if ($tipos_secretariados == null) {
            return Redirect('tiposSecretariados')->with('mensaje', 'No se encuentra el tipo de secretariado seleccionado.');
        }
        return view('tiposSecretariados.modificar', compact('tipos_secretariados', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposSecretariados $request)
    {
        $tipos_secretariados = tiposSecretariados::find($id);
        if ($tipos_secretariados == null) {
            return Redirect('tiposSecretariados')->with('mensaje', 'No se encuentra el tipo de secretariado seleccionado.');
        }
        $tipos_secretariados->tipo_secretariado = \Request::input('tipo_secretariado');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipos_secretariados->activo = \Request::input('activo');
        }
        try {
            $tipos_secretariados->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposSecretariados.index')
                        ->with('mensaje', 'Modificar tipo secretariado error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposSecretariados.index')
            ->with('mensaje', 'El tipo de secretariado se ha modificado satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipos_secretariados = tiposSecretariados::find($id);
        if ($tipos_secretariados == null) {
            return Redirect('tiposSecretariados')->with('mensaje', 'No se encuentra el tipo de secretariado seleccionado.');
        }
        $comunidad = $tipos_secretariados->secretariado;
        try {
            $tipos_secretariados->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposSecretariados.index')
                        ->with('mensaje', 'El tipo de secretariado ' . $comunidad . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('tiposSecretariados.index')
                        ->with('mensaje', 'Eliminar tipo secretariado error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposSecretariados.index')
            ->with('mensaje', 'El tipo de secretariado se ha eliminado correctamente.');
    }
}
