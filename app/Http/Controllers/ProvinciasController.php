<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesProvincias;

//Validación

class ProvinciasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Provincias";
        //Vamos al indice y creamos una paginación de 8 elementos y con ruta provincias
        $paises = Paises::getPaisesFromPaisIdToList(0, true);
        $provincias = Provincias::getProvincias($request);
        return view("provincias.index", compact("provincias", 'paises', "titulo"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Título Vista
        $titulo = "Nueva Provincia";
        $provincia = new Provincias;
        $paises = Paises::getPaisesFromPaisIdToList();
        return view('provincias.nuevo',
            compact(
                'paises',
                'provincia',
                'titulo'
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea provincias vacías. con store()
    public function store(ValidateRulesProvincias $request)
    {
        $provincia = new Provincias; //Creamos instancia al modelo
        $provincia->pais_id = $request->get('pais');
        $provincia->provincia = strtoupper($request->get('provincia')); //Asignamos el valor al campo.
        try {
            $provincia->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()
                        ->route('provincias.create')
                        ->with('mensaje', 'La provincia ' . $provincia->provincia . ' está ya dada de alta.');
                    break;
                default:
                    return redirect()
                        ->route('provincias.index')
                        ->with('mensaje', 'Nueva provincia error ' . $e->getCode());
            }
        }
        return redirect('provincias')
            ->with('mensaje', 'La provincia ' . $provincia->provincia . ' ha sido creada satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //Título Vista
        $titulo = 'Detalles Provincia';
        //Nos situamos sobre la provincia.
        $provincia = Provincias::find($id);
        if ($provincia == null) {
            return Redirect('provincias')->with('mensaje', 'No se encuentra la provincia seleccionada.');
        }
        //Vista
        return view('provincias.mostrar',
            compact(
                'provincia',
                'titulo'
            ));

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
        $titulo = 'Modificar Provincia';
        $provincia = Provincias::find($id);
        if ($provincia == null) {
            return Redirect('provincias')->with('mensaje', 'No se encuentra la provincia seleccionada.');
        }
        $paises = Paises::getPaisesFromPaisIdToList($provincia->pais_id);
        return view('provincias.modificar',
            compact(
                'paises',
                'provincia',
                'titulo'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesProvincias $request)
    {
        $provincia = Provincias::find($id);
        if ($provincia == null) {
            return Redirect('provincias')->with('mensaje', 'No se encuentra la provincia seleccionada.');
        }
        $provincia->pais_id = $request->get('pais');
        $provincia->provincia = strtoupper($request->get('provincia'));
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $provincia->activo = $request->get('activo');
        }
        try {
            $provincia->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()
                        ->route('provincias.index')
                        ->with('mensaje', 'Modificar provincia error ' . $e->getCode());
            }
        }
        return redirect()
            ->route('provincias.index')
            ->with('mensaje', 'La provincia ' . $provincia->provincia . ' ha sido modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $provincia = Provincias::find($id);
        if ($provincia == null) {
            return Redirect('provincias')->with('mensaje', 'No se encuentra la provincia seleccionada.');
        }
        try {
            $provincia->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()
                        ->route('provincias.index')
                        ->with('mensaje', 'La provincia ' . $provincia->provincia . ' no se puede eliminar al tener localidades asociadas.');
                    break;
                default:
                    return redirect()
                        ->route('provincias.index')
                        ->with('mensaje', 'Eliminar provincia error ' . $e->getCode());
            }
        }
        return redirect()
            ->route('provincias.index')
            ->with('mensaje', 'La provincia ' . $provincia->provincia . ' ha sido eliminada correctamente.');
    }

    //Método de actualizar Provincias por Ajax
    public function cambiarProvincias()
    {
        if (\Request::ajax()) {
            $pais_id = (int)\Request::input('pais_id');
            return Provincias::where('pais_id', $pais_id)
                ->where('activo', true)
                ->orderBy('provincia', 'ASC')
                ->select('provincia', 'id')
                ->get();
        }
    }
}
