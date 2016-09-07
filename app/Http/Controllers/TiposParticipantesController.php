<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\TiposParticipantes;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesTiposParticipantes;

//Validación

class TiposParticipantesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Participantes";
        $tiposParticipantes = TiposParticipantes::getTiposParticipantes($request);
        return view("tiposParticipantes.index", compact('tiposParticipantes', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo Participante";
        $tipoParticipante = new TiposParticipantes();
        return view('tiposParticipantes.nuevo', compact('tipoParticipante', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposParticipantes $request)
    {
        $tipoParticipante = new TiposParticipantes(); //Creamos instancia al modelo
        $tipoParticipante->tipo_participante = $request->get('tipo_participante'); //Asignamos el valor al campo.
        try {
            $tipoParticipante->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposParticipantes.create')
                        ->with('mensaje', 'El tipo de participante ' . $tipoParticipante->tipo_participante . ' est&aacute; ya dado de alta.');
                    break;
                default:
                    return redirect()
                        ->route('tiposParticipantes.index')
                        ->with('mensaje', 'Nuevo tipo de participante error ' . $e->getCode());
            }
        }
        return redirect('tiposParticipantes')
            ->with('mensaje', 'El tipo de participante ' . $tipoParticipante->tipo_participante . ' ha sido creado satisfactoriamente.');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar Participante";
        $tipoParticipante = TiposParticipantes::find($id);
        if ($tipoParticipante == null) {
            return Redirect('tiposParticipantes')->with('mensaje', 'No se encuentra el tipo de participante seleccionado.');
        }
        return view('tiposParticipantes.modificar', compact('tipoParticipante', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposParticipantes $request)
    {
        $tipoParticipante = TiposParticipantes::find($id);
        if ($tipoParticipante == null) {
            return Redirect('tiposParticipantes')->with('mensaje', 'No se encuentra el tipo de participante seleccionado.');
        }
        $tipoParticipante->tipo_participante = $request->get('tipo_participante');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipoParticipante->activo = $request->get('activo');
        }
        try {
            $tipoParticipante->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposParticipantes.index')
                        ->with('mensaje', 'Modificar tipo participante error ' . $e->getMessage());
            }
        }
        return redirect()->route('tiposParticipantes.index')
            ->with('mensaje', 'El tipo de participante ' . $tipoParticipante->tipo_participante . ' ha sido modificado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipoParticipante = TiposParticipantes::find($id);
        if ($tipoParticipante == null) {
            return Redirect('tiposParticipantes')->with('mensaje', 'No se encuentra el tipo de participante seleccionado.');
        }
        try {
            $tipoParticipante->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposParticipantes.index')
                        ->with('mensaje', 'El tipo de participante ' . $tipoParticipante->tipo_participante . ' no se puede eliminar al tener cursillos asociados.');
                    break;
                default:
                    return redirect()->route('tiposParticipantes.index')
                        ->with('mensaje', 'Eliminar tipo participante error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposParticipantes.index')
            ->with('mensaje', 'El tipo de participante ' . $tipoParticipante->tipo_participante . ' ha sido eliminado correctamente.');
    }
}
