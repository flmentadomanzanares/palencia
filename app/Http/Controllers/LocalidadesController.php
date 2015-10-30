<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;

//Validación
use Palencia\Http\Requests\ValidateRulesLocalidades;


class LocalidadesController extends Controller
{

    /**
     * Display a listing of the resource.
     *ABA
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de Localidades";
        //Vamos al indice y creamos una paginación de 4 elementos y con ruta localidades
        $paises = Paises::getPaisesList();
        $provincias = Provincias::getProvinciasList();
        $localidades = Localidades::getLocalidades($request);;
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
        $localidades = new Localidades();
        $paises = Paises::getPaisesList();
        $provincias = Array();
        return view('localidades.nuevo', compact('localidades', 'provincias', 'paises', 'titulo'));
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
        $localidades = new Localidades; //Creamos instancia al modelo
        $localidades->provincia_id = \Request::input('provincia');
        $localidades->localidad = \Request::input('localidad'); //Asignamos el valor al campo.
        try {
            $localidades->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('localidades.create')
                        ->with('mensaje', 'La localidad ' . \Request::input('localidad') . ' está ya dada de alta.');
                    break;
                default:
                    return redirect()
                        ->route('localidades.index')
                        ->with('mensaje', 'Nueva localidad error ' . $e->getCode());
            }
        }
        return redirect('localidades')
            ->with('mensaje', 'La localidad ' . $localidades->localidad . ' creada satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
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
        $localidades = Localidades::find($id);
        $provincias = Provincias::getProvinciasAll($localidades->provincia_id);
        $paises = Paises::getPaisesAll($localidades->provincia_id);
        return view('localidades.modificar',
            compact(
                'localidades',
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
        $localidades = Localidades::find($id);
        $localidades->localidad = \Request::input('localidad');
        $localidades->provincia_id = \Request::input('provincia');
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $localidades->activo = \Request::input('activo');
        }
        try {
            $localidades->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('localidades.index')->with('mensaje', 'Modificar localidad error ' . $e->getCode());
            }
        }
        return redirect()
            ->route('localidades.index')
            ->with('mensaje', 'La localidad ha sido modificada satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $localidades = Localidades::find($id);
        $localidadNombre = $localidades->localidad;
        try {
            $localidades->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()
                        ->route('localidades.index')
                        ->with('mensaje', 'La localidad ' . $localidadNombre . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()
                        ->route('localidades.index')
                        ->with('mensaje', 'Eliminar localidad error ' . $e->getCode());
            }

        }

        return redirect()
            ->route('localidades.index')
            ->with('mensaje', 'La localidad ' . $localidadNombre . ' eliminada correctamente.');
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
                ->orderBy('localidad', 'ASC')
                ->select('localidad', 'id')
                ->get();
            return $localidades;
        }
        return null;
    }
}
