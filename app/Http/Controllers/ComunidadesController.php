<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\Colores;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;
use Palencia\Entities\TiposComunicacionesPreferidas;
use Palencia\Entities\TiposSecretariados;
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
        if (!auth()->check())
            return View("comun.invitado");
        $titulo = "Listado de comunidades";
        $comunidades = Comunidades::getComunidades($request);
        $secretariados = TiposSecretariados::getTiposSecretariadosList();
        $paises = Paises::getPaisesList();
        $provincias = Provincias::getProvinciasList();
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
        $comunidad = new Comunidades();
        $secretariados = TiposSecretariados::getTiposSecretariadosList();
        $paises = Paises::getPaisesList();
        $provincias = Provincias::getProvinciasList();
        $localidades = Localidades::getLocalidadesList();
        $comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList();
        $colors = Colores::getColores();
        return view('comunidades.nuevo',
            compact(
                'comunidad',
                'secretariados',
                'paises',
                'provincias',
                'localidades',
                'comunicaciones_preferidas',
                'colors',
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
        $comunidad = new Comunidades();
        $comunidad->comunidad = \Request::input('comunidad');
        $comunidad->esPropia = \Request::input('esPropia');
        $comunidad->tipo_secretariado_id = \Request::input('tipo_secretariado_id');
        $comunidad->responsable = \Request::input('responsable');
        $comunidad->direccion = \Request::input('direccion');
        $comunidad->cp = \Request::input('cp');
        $comunidad->pais_id = \Request::input('pais_id');
        $comunidad->provincia_id = \Request::input('provincia_id');
        $comunidad->localidad_id = \Request::input('localidad_id');
        $comunidad->email_solicitud = \Request::input('email1');
        $comunidad->email_envio = \Request::input('email2');
        $comunidad->web = \Request::input('web');
        $comunidad->facebook = \Request::input('facebook');
        $comunidad->telefono1 = \Request::input('telefono1');
        $comunidad->telefono2 = \Request::input('telefono2');
        $comunidad->tipo_comunicacion_preferida_id = \Request::input('tipo_comunicacion_preferida_id');
        $comunidad->observaciones = \Request::input('observaciones');
        $comunidad->esColaborador = \Request::input('esColaborador');
        $comunidad->color = \Request::input('color');
        $comunidad->activo = \Request::input('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $comunidad->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 230000:
                    return redirect()->
                    route('comunidades.index')->
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
        $titulo = "Detalles Comunidad";
        $comunidad = Comunidades::getComunidad($id);
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
        $comunidad = Comunidades::find($id);
        $secretariados = TiposSecretariados::getTiposSecretariadosList();
        $paises = Paises::getPaisesList();
        $provincias = Provincias::getProvinciasList();
        $localidades = Localidades::getLocalidadesList();
        $comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList();
        $colors = Colores::getColores();
        return view('comunidades.modificar',
            compact(
                'comunidad',
                'secretariados',
                'paises',
                'provincias',
                'localidades',
                'comunicaciones_preferidas',
                'colors',
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
        $comunidad = Comunidades::find($id);
        $comunidad->comunidad = \Request::input('comunidad');
        $comunidad->esPropia = \Request::input('esPropia');
        $comunidad->tipo_secretariado_id = \Request::input('tipo_secretariado_id');
        $comunidad->responsable = \Request::input('responsable');
        $comunidad->direccion = \Request::input('direccion');
        $comunidad->cp = \Request::input('cp');
        $comunidad->pais_id = \Request::input('pais_id');
        $comunidad->provincia_id = \Request::input('provincia_id');
        $comunidad->localidad_id = \Request::input('localidad_id');
        $comunidad->email_solicitud = \Request::input('email1');
        $comunidad->email_envio = \Request::input('email2');
        $comunidad->web = \Request::input('web');
        $comunidad->facebook = \Request::input('facebook');
        $comunidad->telefono1 = \Request::input('telefono1');
        $comunidad->telefono2 = \Request::input('telefono2');
        $comunidad->tipo_comunicacion_preferida_id = \Request::input('tipo_comunicacion_preferida_id');
        $comunidad->observaciones = \Request::input('observaciones');
        $comunidad->esColaborador = \Request::input('esColaborador');
        $comunidad->color = \Request::input('color');
        $comunidad->activo = \Request::input('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $comunidad->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('comunidades.index')->
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
        return redirect()->route('comunidades.index')
            ->with('mensaje', 'La comunidad ha sido eliminada correctamente.');
    }
}
