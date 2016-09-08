<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesLocalidades;

//Validación


class LocalidadesController extends Controller
{

    /**
     * Display a listing of the resource.
     *ABA
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Localidades";
        //Vamos al indice y creamos una paginación de 4 elementos y con ruta localidades
        $paises = Paises::getPaisesFromPaisIdToList(0, true);
        $provincias = array();
        $localidades = Localidades::getLocalidades($request, config("opciones.paginacion"));
        return view("localidades.index", compact('localidades', 'paises', 'provincias', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nueva localidad";
        $localidad = new Localidades();
        $paises = Paises::getPaisesFromPaisIdToList();
        $provincias = Array();
        return view('localidades.nuevo', compact('localidad', 'provincias', 'paises', 'titulo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea localidades vacías. con store()
    /**
     * @param ValidateRulesLocalidades $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ValidateRulesLocalidades $request)
    {
        $localidad = new Localidades; //Creamos instancia al modelo
        $localidad->provincia_id = $request->get('provincia');
        $localidad->localidad = strtoupper($request->get('localidad')); //Asignamos el valor al campo.
        try {
            $localidad->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('localidades.create')
                        ->with('mensaje', 'La localidad ' . $localidad->localidad . ' est&aacute; ya dada de alta.');
                    break;
                default:
                    return redirect()
                        ->route('localidades.index')
                        ->with('mensaje', 'Nueva localidad error ' . $e->getCode());
            }
        }
        return redirect('localidades')
            ->with('mensaje', 'La localidad ' . $localidad->localidad . ' ha sido creada satisfactoriamente.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //Título Vista
        $titulo = "Modificar Localidad";
        $localidad = Localidades::find($id);
        if ($localidad == null) {
            return Redirect('localidades')->with('mensaje', 'No se encuentra la localidad seleccionada.');
        }

        $paises = Paises::getPaisFromProvinciaIdToList($localidad->provincia_id);
        $provincias = [];
        return view('localidades.modificar',
            compact(
                'localidad',
                'paises',
                'provincias',
                'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesLocalidades $request)
    {
        $localidad = Localidades::find($id);
        if ($localidad == null) {
            return Redirect('localidades')->with('mensaje', 'No se encuentra la localidad seleccionada.');
        }
        $localidad->localidad = strtoupper($request->get('localidad'));
        $localidad->provincia_id = $request->get('provincia');
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $localidad->activo = $request->get('activo');
        }
        try {
            $localidad->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('localidades.index')->with('mensaje', 'Modificar localidad error ' . $e->getCode());
            }
        }
        return redirect()
            ->route('localidades.index')
            ->with('mensaje', 'La localidad ' . $localidad->localidad . ' ha sido modificada satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $localidad = Localidades::find($id);
        if ($localidad == null) {
            return Redirect('localidades')->with('mensaje', 'No se encuentra la localidad seleccionada.');
        }
        try {
            $localidad->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()
                        ->route('localidades.index')
                        ->with('mensaje', 'La localidad ' . $localidad->localidad . ' no se puede eliminar al tener comunidades asociadas.');
                    break;
                default:
                    return redirect()
                        ->route('localidades.index')
                        ->with('mensaje', 'Eliminar localidad error ' . $e->getCode());
            }
        }
        return redirect()
            ->route('localidades.index')
            ->with('mensaje', 'La localidad ' . $localidad->localidad . ' ha sido eliminada correctamente.');
    }

    /**
     * Método de actualizar Localidades por Ajax
     * @return mixed
     */
    public function cambiarLocalidades()
    {
        if (\Request::ajax()) {
            $provincia_id = \Request::input('provincia_id');
            $localidades = Localidades::where('provincia_id', $provincia_id)
                ->where('activo', true)
                ->orderBy('localidad', 'ASC')
                ->select('localidad', 'id')
                ->get();
            return $localidades;
        }
        return null;
    }
}
