<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;

//Validación
use Palencia\Http\Requests\ValidateRulesProvincias;

class ProvinciasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //Vamos al indice y creamos una paginación de 8 elementos y con ruta provincias
        $paises=['0'=>'Elige País']+Paises::orderBy('pais', 'ASC')->lists('pais','id');
        $provincias = Provincias::pais($request->get('pais'))->provincia($request->get('provincia'))->orderBy('provincia', 'ASC')->paginate()->setPath('provincias');
        return view("provincias.index", compact('provincias','paises'))->with('titulo', 'Listado de Provincias');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $provincias = new Provincias;
        $paises=['0'=>'Elige País']+Paises::orderBy('pais', 'ASC')->lists('pais','id');
        return view('provincias.nuevo',compact('provincias','paises'))->with('titulo', 'Nueva Provincia');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea provincias vacías. con store()
    public function store(ValidateRulesProvincias $request)
    {
        $provincias = new Provincias; //Creamos instancia al modelo

        $provincias->pais_id = \Request::input('pais');
        $provincias->provincia = \Request::input('provincia'); //Asignamos el valor al campo.
        try {
            $provincias->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('provincias.create')->with('mensaje', 'La provincia ' . \Request::input('provincia') . ' está ya dada de alta.');
                    break;
                default:
                    return redirect()->route('provincias.index')->with('mensaje', 'Nueva provincia error ' . $e->getCode());
            }
        }
        return redirect('provincias')->with('mensaje', 'La provincia ' . $provincias->provincia . ' creada satisfactoriamente.');

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
        $provincias = Provincias::find($id);

        //Vista
        return view('provincias.mostrar',
            compact(
                'provincias',
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
        $paises=['0'=>'Elige País']+Paises::orderBy('pais', 'ASC')->lists('pais','id');
        return view('provincias.modificar',compact('paises'))->with('provincias', Provincias::find($id))->with('titulo', 'Modificar Provincia');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesProvincias $request)
    {
        $provincias = Provincias::find($id);
        $provincias->pais_id = \Request::input('pais');
        $provincias->provincia = \Request::input('provincia');
        if (\Auth::user()->roles->peso >= config('opciones.roles.administrador')) {
            $provincias->activo = \Request::input('activo');
        }
        try {
            $provincias->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route('provincias.index')->with('mensaje', 'Modificar provincia error ' . $e->getCode());
            }
        }
        return redirect()->route('provincias.index')->with('mensaje', 'provincia modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $provincias = Provincias::find($id);
        $provinciaNombre = $provincias->provincia;
        try {
            $provincias->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('provincias.index')->with('mensaje', 'La provincia ' . $provinciaNombre . ' no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('provincias.index')->with('mensaje', 'Eliminar provincia error ' . $e->getCode());
            }
        }
        return redirect()->route('provincias.index')->with('mensaje', 'La provincia ' . $provinciaNombre . ' eliminada correctamente.');
    }

    //Método de actualizar Provincias por Ajax
    public function cambiarProvincias()
    {
        if (\Request::ajax()) {
            $pais_id = (int)\Request::input('pais_id');
            $provincias = Provincias::where('pais_id', $pais_id)->orderBy('provincia','ASC')->select('provincia', 'id')->get();
            return $provincias;
        }
    }
}
