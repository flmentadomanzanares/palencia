<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use Palencia\Http\Requests\ValidateRulesComunidades;

class ComunidadesController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de comunidades";
        $comunidades = Comunidades::getComunidades($request);
        $secretariados = Comunidades::getSecretariadosList();
        $paises = Comunidades::getPaisesList();
        $provincias = Comunidades::getProvinciasList();
        return view("comunidades.index",
            compact('comunidades',
                'secretariados',
                'paises',
                'provincias',
                'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Título Vista
        $titulo = "Nueva Comunidad";
        $comunidades = new Comunidades();
        $secretariados = Comunidades::getSecretariadosList();
        $paises = Comunidades::getPaisesList();
        $provincias = Comunidades::getProvinciasList();
        $localidades = Comunidades::getLocalidadesList();
        $comunicaciones_preferidas = Comunidades::getComunicacionesPreferidasList();
        return view('comunidades.nuevo',
            compact(
                'comunidades',
                'secretariados',
                'paises',
                'provincias',
                'localidades',
                'comunicaciones_preferidas',
                'titulo'
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ValidateRulesComunidades $request)
    {
        //Creamos una nueva instancia al modelo.
        $comunidades = new Comunidades();
        $comunidades->comunidad = \Request::input('comunidad');
        $comunidades->tipo_secretariado_id = \Request::input('tipo_secretariado_id');
        $comunidades->responsable = \Request::input('responsable');
        $comunidades->direccion = \Request::input('direccion');
        $comunidades->cp = \Request::input('cp');
        $comunidades->pais_id = \Request::input('pais_id');
        $comunidades->provincia_id = \Request::input('provincia_id');
        $comunidades->localidad_id = \Request::input('localidad_id');
        $comunidades->email1 = \Request::input('email1');
        $comunidades->email2 = \Request::input('email2');
        $comunidades->web = \Request::input('web');
        $comunidades->facebook = \Request::input('facebook');
        $comunidades->telefono1 = \Request::input('telefono1');
        $comunidades->telefono2 = \Request::input('telefono2');
        $comunidades->tipo_comunicacion_preferida_id = \Request::input('tipo_comunicacion_preferida_id');
        $comunidades->observaciones = \Request::input('observaciones');
        $comunidades->activo = \Request::input('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $comunidades->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 230000:
                    return redirect()->
                    route('comunidades.create')->
                    with('mensaje', 'la comunidad está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('comunidades.index')->
                    with('mensaje', 'Nueva Comunidad error ' . $e->getMessage());
            }
        }
        //Redireccionamos a Comunidades (index)
        return redirect('comunidades')->
        with('mensaje', 'La comunidad  ha sido creada satisfactoriamente.');
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
        $titulo = "Modificar Comunidad";
        $comunidad = Comunidades::getComunidad($id);
        if (count($comunidad) == 0)
            return redirect()->back()->with('mensaje', 'No existen detalles.');
        return view('comunidades.ver',
            compact(
                'comunidad',
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
        $titulo = "Modificar Comunidad";
        $comunidades = Comunidades::find($id);
        $secretariados = Comunidades::getSecretariadosList();
        $paises = Comunidades::getPaisesList();
        $provincias = Comunidades::getProvinciasList();
        $localidades = Comunidades::getLocalidadesList();
        $comunicaciones_preferidas = Comunidades::getComunicacionesPreferidasList();
        return view('comunidades.modificar',
            compact(
                'comunidades',
                'secretariados',
                'paises',
                'provincias',
                'localidades',
                'comunicaciones_preferidas',
                'titulo'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesComunidades $request)
    {
        //Creamos una nueva instancia al modelo.
        $comunidades = Comunidades::find($id);
        $comunidades->comunidad = \Request::input('comunidad');
        $comunidades->tipo_secretariado_id = \Request::input('tipo_secretariado_id');
        $comunidades->responsable = \Request::input('responsable');
        $comunidades->direccion = \Request::input('direccion');
        $comunidades->cp = \Request::input('cp');
        $comunidades->pais_id = \Request::input('pais_id');
        $comunidades->provincia_id = \Request::input('provincia_id');
        $comunidades->localidad_id = \Request::input('localidad_id');
        $comunidades->email1 = \Request::input('email1');
        $comunidades->email2 = \Request::input('email2');
        $comunidades->web = \Request::input('web');
        $comunidades->facebook = \Request::input('facebook');
        $comunidades->telefono1 = \Request::input('telefono1');
        $comunidades->telefono2 = \Request::input('telefono2');
        $comunidades->tipo_comunicacion_preferida_id = \Request::input('tipo_comunicacion_preferida_id');
        $comunidades->observaciones = \Request::input('observaciones');
        $comunidades->activo = \Request::input('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $comunidades->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('comunidades.create')->
                    with('mensaje', 'la comunidad está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('comunidades.index')->
                    with('mensaje', 'Modificar Comunidad error ' . $e->getCode());
            }
        }
        //Redireccionamos a Comunidades (index)
        return redirect('comunidades')->
        with('mensaje', 'La comunidad  ha sido  modificada satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $comunidad = Comunidades::find($id);
        try {
            $comunidad->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('comunidades.index')->with('mensaje', 'La comunidad  no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('comunidades.index')->with('mensaje', 'Eliminar comunidad error ' . $e->getCode());
            }
        }
        return redirect()->route('comunidades.index')->with('mensaje', 'La comunidad ha sido eliminada correctamente.');
    }


}
