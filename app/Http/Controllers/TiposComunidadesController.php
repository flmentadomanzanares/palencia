<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\tiposComunidades;

//Validación
use Palencia\Http\Requests\ValidateRulesTiposComunidades;

class TiposComunidadesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de tipos de comunidades";
        $tipos_comunidades = tiposComunidades::tipoComunidad($request->get('comunidad'))
            ->orderBy('comunidad', 'ASC')
            ->paginate()
            ->setPath('tiposComunidades');
        return view("tiposComunidades.index", compact('tipos_comunidades', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo tipo de comunidad";
        $tipos_comunidades = new tiposComunidades();
        return view('tiposComunidades.nuevo', compact('tipos_comunidades', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesTiposComunidades $request)
    {
        $tipos_comunidades = new tiposComunidades(); //Creamos instancia al modelo
        $tipos_comunidades->comunidad = \Request::input('comunidad'); //Asignamos el valor al campo.
        try {
            $tipos_comunidades->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposComunidades.create')
                        ->with('mensaje', 'El tipo de comunidad ' . \Request::input('comunidad') . ' está ya dado de alta . ');
                    break;
                default:
                    return redirect()
                        ->route('tiposComunidades.index')
                        ->with('mensaje', 'Nuevo país error ' . $e->getCode());
            }
        }
        return redirect('tiposComunidades')
            ->with('mensaje', 'El tipo de comunidad ' . $tipos_comunidades->comunidad . ' creado satisfactoriamente . ');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar tipo de comunidad";
        $tipos_comunidades = tiposComunidades::find($id);
        return view('tiposComunidades.modificar', compact('tipos_comunidades','titulo'));
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesTiposComunidades $request)
    {
        $tipos_comunidades = tiposComunidades::find($id);
        $tipos_comunidades->comunidad = \Request::input('comunidad');
        if (\Auth::user()->roles->peso >= config('opciones . roles . administrador')) {
            $tipos_comunidades->activo = \Request::input('activo');
        }
        try {
            $tipos_comunidades->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('tiposComunidades.index')
                        ->with('mensaje', 'Modificar tipo comunidad error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposComunidades.index')
            ->with('mensaje', 'El tipo de comunidad se ha modificado satisfactoriamente . ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $tipos_comunidades = tiposComunidades::find($id);
        $comunidad =$tipos_comunidades->comunidad;
        try {
            $tipos_comunidades->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('tiposComunidades.index')
                        ->with('mensaje', 'El tipo de comunidad '.$comunidad.' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('tiposComunidades.index')
                        ->with('mensaje', 'Eliminar tipo comunidad error ' . $e->getCode());
            }
        }
        return redirect()->route('tiposComunidades.index')
            ->with('mensaje', 'El tipo de comunidad se ha eliminado correctamente.');
    }
}
