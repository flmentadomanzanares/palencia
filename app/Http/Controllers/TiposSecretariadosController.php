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
        $titulo = "Secretariados";
        $tipoSecretariados = TiposSecretariados::getTipoSecretariados($request);
        return view("tiposSecretariados.index", compact('tipoSecretariados', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo Secretariado";
        $tipoSecretariado = new tiposSecretariados();
        return view('tiposSecretariados.nuevo', compact('tipoSecretariado', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposSecretariados $request)
    {
        $tipoSecretariado = new tiposSecretariados(); //Creamos instancia al modelo
        $tipoSecretariado->tipo_secretariado = $request->get('tipo_secretariado'); //Asignamos el valor al campo.
        try {
            $tipoSecretariado->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposSecretariados.create')
                        ->with('mensaje', 'El tipo de secretariado ' . $tipoSecretariado->tipo_secretariado . ' est&aacute; ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('tiposSecretariados.index')
                        ->with('mensaje', 'Nuevo tipo de secretariado error ' . $e->getCode());
            }
        }
        return redirect('tiposSecretariados')
            ->with('mensaje', 'El tipo de secretariado ' . $tipoSecretariado->tipo_secretariado . ' ha sido creado satisfactoriamente . ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar Secretariado";
        $tipoSecretariado = tiposSecretariados::find($id);
        if ($tipoSecretariado == null) {
            return Redirect('tiposSecretariados')->with('mensaje', 'No se encuentra el tipo de secretariado seleccionado.');
        }
        return view('tiposSecretariados.modificar', compact('tipoSecretariado', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposSecretariados $request)
    {
        $tipoSecretariado = tiposSecretariados::find($id);
        if ($tipoSecretariado == null) {
            return Redirect('tiposSecretariados')->with('mensaje', 'No se encuentra el tipo de secretariado seleccionado.');
        }
        $tipoSecretariado->tipo_secretariado = $request->get('tipo_secretariado');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipoSecretariado->activo = $request->get('activo');
        }
        try {
            $tipoSecretariado->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposSecretariados.index')
                        ->with('mensaje', 'Modificar tipo secretariado error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposSecretariados.index')
            ->with('mensaje', 'El tipo de secretariado ' . $tipoSecretariado->tipo_secretariado . ' se ha modificado satisfactoriamente. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipoSecretariado = tiposSecretariados::find($id);
        if ($tipoSecretariado == null) {
            return Redirect('tiposSecretariados')->with('mensaje', 'No se encuentra el tipo de secretariado seleccionado.');
        }
        try {
            $tipoSecretariado->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposSecretariados.index')
                        ->with('mensaje', 'El tipo de secretariado ' . $tipoSecretariado->tipo_secretariado . ' no se puede eliminar al tener comunidades asociadas.');
                    break;
                default:
                    return redirect()->route('tiposSecretariados.index')
                        ->with('mensaje', 'Eliminar tipo secretariado error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposSecretariados.index')
            ->with('mensaje', 'El tipo de secretariado ' . $tipoSecretariado->tipo_secretariado . ' se ha eliminado correctamente.');
    }
}
