<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\TiposParticipantes;

//Validación
use Palencia\Http\Requests\ValidateRulesTiposParticipantes;

class TiposParticipantesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de tipos de participantes";
        $tipos_participantes = TiposParticipantes::tipoParticipante($request->get('participante'))
            ->orderBy('participante', 'ASC')
            ->paginate()
            ->setPath('tiposParticipantes');

        return view("tiposParticipantes.index", compact('tipos_participantes', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo tipo de participante";
        $tipos_participantes = new TiposParticipantes();
        return view('tiposParticipantes.nuevo', compact('tipos_participantes', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposParticipantes $request)
    {
        $tipos_participantes = new TiposParticipantes(); //Creamos instancia al modelo
        $tipos_participantes->participante = \Request::input('participante'); //Asignamos el valor al campo.
        try {
            $tipos_participantes->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposParticipantes.create')
                        ->with('mensaje', 'El tipo de participante ' . \Request::input('participante') . ' está ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('tiposParticipantes.index')
                        ->with('mensaje', 'Nuevo país error ' . $e->getCode());
            }
        }
        return redirect('tiposParticipantes')
            ->with('mensaje', 'El tipo de participante ' . $tipos_participantes->participante . ' creado satisfactoriamente . ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar tipo de participante";
        $tipos_participantes = TiposParticipantes::find($id);
        return view('tiposParticipantes.modificar', compact('tipos_participantes','titulo'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposParticipantes $request)
    {
        $tipos_participantes = TiposParticipantes::find($id);
        $tipos_participantes->participante = \Request::input('participante');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipos_participantes->activo = \Request::input('activo');
        }
        try {
            $tipos_participantes->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposParticipantes.index')
                        ->with('mensaje', 'Modificar tipo participante error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposParticipantes.index')
            ->with('mensaje', 'El tipo de participante se ha modificado satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipos_participantes = TiposParticipantes::find($id);
        $participante =$tipos_participantes->participante;
        try {
            $tipos_participantes->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposParticipantes.index')
                        ->with('mensaje', 'El tipo de participante '.$participante.' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('tiposParticipantes.index')
                        ->with('mensaje', 'Eliminar ptipo participante error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposParticipantes.index')
            ->with('mensaje', 'El tipo de participante eliminado correctamente.');
    }
}
