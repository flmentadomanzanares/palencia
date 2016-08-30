<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\TiposComunicacionesPreferidas;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesTiposComunicacionesPreferidas;

//Validación

class TiposComunicacionesPreferidasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado Tipos Comunicaciones Preferidas";
        $tiposComunicacionesPreferidas =
            TiposComunicacionesPreferidas::getTiposComunicacionesPreferidas($request);
        return view("tiposComunicacionesPreferidas.index", compact('tiposComunicacionesPreferidas', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo Tipo Comunicaci&oacute;n Preferida";
        $tipoComunicacionPreferida = new TiposComunicacionesPreferidas();
        return view('tiposComunicacionesPreferidas.nuevo', compact('tipoComunicacionPreferida', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposComunicacionesPreferidas $request)
    {
        $tipoComunicacionPreferida = new TiposComunicacionesPreferidas(); //Creamos instancia al modelo
        $tipoComunicacionPreferida->comunicacion_preferida = $request->get('comunicacion_preferida'); //Asignamos el valor al campo.
        try {
            $tipoComunicacionPreferida->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposComunicacionesPreferidas.create')
                        ->with('mensaje', 'El tipo de comunicacion preferida ' . $request->get('comunicacion_preferida') . ' est&aacute; ya dado de alta. ');
                    break;
                default:
                    return redirect()
                        ->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'Nueva comunicaci&oacute;n preferida error ' . $e->getCode());
            }
        }
        return redirect('tiposComunicacionesPreferidas')
            ->with('mensaje', 'El tipo de comunicacion preferida ' . $tipoComunicacionPreferida->comunicacion_preferida . ' ha sido creada satisfactoriamente. ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar Tipo Comunicaci&oacute;n Preferida";
        $tipoComunicacionPreferida = TiposComunicacionesPreferidas::find($id);
        if ($tipoComunicacionPreferida == null) {
            return Redirect('tiposComunicacionesPreferidas')->with('mensaje', 'No se encuentra el tipo de comunicaci&oacute;n preferida seleccionada.');
        }
        return view('tiposComunicacionesPreferidas.modificar', compact('tipoComunicacionPreferida', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposComunicacionesPreferidas $request)
    {
        $tipoComunicacionPreferida = TiposComunicacionesPreferidas::find($id);
        if ($tipoComunicacionPreferida == null) {
            return Redirect('tiposComunicacionesPreferidas')->with('mensaje', 'No se encuentra el tipo de comunicaci&oacute;n preferida seleccionada.');
        }
        $tipoComunicacionPreferida->comunicacion_preferida = $request->get('comunicacion_preferida');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipoComunicacionPreferida->activo = $request->get('activo');
        }
        try {
            $tipoComunicacionPreferida->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'Modificar tipo comunicacion preferida error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposComunicacionesPreferidas.index')
            ->with('mensaje', 'El tipo de comunicacion preferida ' . $tipoComunicacionPreferida->comunicacion_preferida . ' ha sido modificada satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipoComunicacionPreferida = TiposComunicacionesPreferidas::find($id);
        if ($tipoComunicacionPreferida == null) {
            return Redirect('tiposComunicacionesPreferidas')->with('mensaje', 'No se encuentra el tipo de comunicaci&oacute;n preferida seleccionada.');
        }
        try {
            $tipoComunicacionPreferida->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'El tipo de comunicacion preferida ' . $tipoComunicacionPreferida->comunicacion_preferida . ' no se puede eliminar al tener comunidades asociadas.');
                    break;
                default:
                    return redirect()->route('tiposComunicacionesPreferidas.index')
                        ->with('mensaje', 'Eliminar tipo comunicacion preferida error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposComunicacionesPreferidas.index')
            ->with('mensaje', 'El tipo de comunicacion preferida ' . $tipoComunicacionPreferida->comunicacion_preferida . ' se ha eliminado correctamente.');
    }
}
