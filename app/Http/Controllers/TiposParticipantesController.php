<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\TiposParticipantes;

//Validación
use Palencia\Http\Requests\ValidateRulesTiposParticipantes;

class TiposParticipantesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo="Listado de tipos de participantes";
        $tipoParticipantes= TiposParticipantes::tipoParticipante($request->get('tipoParticipante'))
            ->orderBy('tipo_participante', 'ASC')
            ->paginate()
            ->setPath('participantes');

        return view("tipoParticipantes.index",compact('tipoParticipantes','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $paises = new Paises;
        return view('paises.nuevo')->with('paises', $paises)->with('titulo','Nuevo País');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesPaises $request)
    {
        $paises = new Paises; //Creamos instancia al modelo

        $paises->pais = \Request::input('pais'); //Asignamos el valor al campo.
        try {
            $paises->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('paises.create')->with('mensaje', 'El país ' . \Request::input('pais') . ' está ya dado de alta.');
                    break;
                default:
                    return redirect()->route('paises.index')->with('mensaje', 'Nuevo país error ' . $e->getCode());
            }
        }
        return redirect('paises')->with('mensaje', 'El país ' . $paises->pais . ' creado satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('paises.modificar')->with('paises', Paises::find($id))->with('titulo','Modificar País');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, ValidateRulesPaises $request)
    {
        $paises = Paises::find($id);
        $paises->pais = \Request::input('pais');
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $paises->activo = \Request::input('activo');
        }
        try {
            $paises->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route('paises.index')->with('mensaje', 'Modificar país error ' . $e->getCode());
            }
        }
        return redirect()->route('paises.index')->with('mensaje', 'País  modificado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $paises = Paises::find($id);
        $paisNombre = $paises->pais;
        try {
            $paises->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('paises.index')->with('mensaje', 'El país ' . $paisNombre . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('paises.index')->with('mensaje', 'Eliminar país error ' . $e->getCode());
            }

        }

        return redirect()->route('paises.index')->with('mensaje', 'El país ' . $paisNombre . ' eliminado correctamente.');
    }
}
