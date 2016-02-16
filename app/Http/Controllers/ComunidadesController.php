<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Colores;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;
use Palencia\Entities\TiposComunicacionesPreferidas;
use Palencia\Entities\TiposSecretariados;
use Palencia\Http\Requests;
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
        $titulo = "Comunidades";
        $comunidades = Comunidades::getComunidades($request);
        $secretariados = TiposSecretariados::getTiposSecretariadosList();
        $paises = Paises::getPaisesFromPaisIdToList(0, true);
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
        $paises = Paises::getPaisesFromPaisIdToList();
        $provincias = Provincias::getProvinciasList();
        $localidades = Localidades::getLocalidadesList();
        $comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList();
        $colores = Colores::getColores();
        return view('comunidades.nuevo',
            compact(
                'comunidad',
                'secretariados',
                'paises',
                'provincias',
                'localidades',
                'comunicaciones_preferidas',
                'colores',
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
        $comunidad->comunidad = $request->get('comunidad');
        $comunidad->esPropia = $request->get('esPropia');
        $comunidad->tipo_secretariado_id = $request->get('tipo_secretariado_id');
        $comunidad->responsable = $request->get('responsable');
        $comunidad->direccion = $request->get('direccion');
        $comunidad->direccion_postal = $request->get('direccion_postal');
        $comunidad->cp = $request->get('cp');
        $comunidad->pais_id = $request->get('pais_id');
        $comunidad->provincia_id = $request->get('provincia_id');
        $comunidad->localidad_id = $request->get('localidad_id');
        $comunidad->email_solicitud = $request->get('email_solicitud');
        $comunidad->email_envio = $request->get('email_envio');
        $comunidad->web = $request->get('web');
        $comunidad->facebook = $request->get('facebook');
        $comunidad->telefono1 = $request->get('telefono1');
        $comunidad->telefono2 = $request->get('telefono2');
        $comunidad->tipo_comunicacion_preferida_id = $request->get('tipo_comunicacion_preferida_id');
        $comunidad->observaciones = $request->get('observaciones');
        $comunidad->esColaborador = $request->get('esColaborador');
        $comunidad->color = $request->get('color');
        $comunidad->activo = $request->get('activo');
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
        with('mensaje', 'La comunidad ' . $comunidad->comunidad . ' ha sido creada satisfactoriamente.');
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
        if ($comunidad == null) {
            return Redirect('comunidades')->with('mensaje', 'No se encuentra la comunidad seleccionada.');
        }
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
        if ($comunidad == null) {
            return Redirect('comunidades')->with('mensaje', 'No se encuentra la comunidad seleccionada.');
        }
        $secretariados = TiposSecretariados::getTiposSecretariadosList();
        $paises = Paises::getPaisFromProvinciaIdToList($comunidad->provincia_id);
        $provincias = Provincias::getProvinciaToList($comunidad->provincia_id);
        $localidades = Localidades::getLocalidadesList();
        $comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList();
        $colores = Colores::getColores();
        return view('comunidades.modificar',
            compact(
                'comunidad',
                'secretariados',
                'paises',
                'provincias',
                'localidades',
                'comunicaciones_preferidas',
                'colores',
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
        if ($comunidad == null) {
            return Redirect('comunidades')->with('mensaje', 'No se encuentra la comunidad seleccionada.');
        }
        $comunidad->comunidad = $request->get('comunidad');
        $comunidad->esPropia = $request->get('esPropia');
        $comunidad->tipo_secretariado_id = $request->get('tipo_secretariado_id');
        $comunidad->responsable = $request->get('responsable');
        $comunidad->direccion = $request->get('direccion');
        $comunidad->direccion_postal = $request->get('direccion_postal');
        $comunidad->cp = $request->get('cp');
        $comunidad->pais_id = $request->get('pais_id');
        $comunidad->provincia_id = $request->get('provincia_id');
        $comunidad->localidad_id = $request->get('localidad_id');
        $comunidad->email_solicitud = $request->get('email_solicitud');
        $comunidad->email_envio = $request->get('email_envio');
        $comunidad->web = $request->get('web');
        $comunidad->facebook = $request->get('facebook');
        $comunidad->telefono1 = $request->get('telefono1');
        $comunidad->telefono2 = $request->get('telefono2');
        $comunidad->tipo_comunicacion_preferida_id = $request->get('tipo_comunicacion_preferida_id');
        $comunidad->observaciones = $request->get('observaciones');
        $comunidad->esColaborador = $request->get('esColaborador');
        $comunidad->color = $request->get('color');
        $comunidad->activo = $request->get('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $comunidad->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('comunidades.index')->
                    with('mensaje', 'la comunidad ' . $comunidad->comunidad . ' está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('comunidades.index')->
                    with('mensaje', 'Modificar Comunidad error ' . $e->getCode());
            }
        }
        //Redireccionamos a Comunidades (index)
        return redirect('comunidades')->
        with('mensaje', 'La comunidad ' . $comunidad->comunidad . ' ha sido  modificada satisfactoriamente.');
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
        if ($comunidad == null) {
            return Redirect('comunidades')->with('mensaje', 'No se encuentra la comunidad seleccionada.');
        }
        try {
            $comunidad->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('comunidades.index')->with('mensaje', 'La comunidad ' . $comunidad->comunidad . '  no se puede eliminar al tener cursillos asociados.');
                    break;
                default:
                    return redirect()->route('comunidades.index')->with('mensaje', 'Eliminar comunidad error ' . $e->getCode());
            }
        }
        return redirect()->route('comunidades.index')
            ->with('mensaje', 'La comunidad ' . $comunidad->comunidad . ' ha sido borrada correctamente.');
    }
}
