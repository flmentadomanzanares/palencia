<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Entities\SolicitudesRecibidasCursillos;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesSolicitudesRecibidas;

class SolicitudesRecibidasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Listado de Solicitudes Recibidas";
        $solicitudesRecibidas = SolicitudesRecibidas::getSolicitudesRecibidas($request);
        $comunidades = SolicitudesRecibidas::getComunidadesSolicitudesRecibidasList();
        return view("solicitudesRecibidas.index", compact('solicitudesRecibidas', 'titulo', 'comunidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Título Vista
        $titulo = "Nueva Solicitud Recibida";
        $solicitudRecibida = new SolicitudesRecibidas();
        $comunidadesPropias = Comunidades::getComunidadesList(1, false, "", true);
        $comunidades = Comunidades::getComunidadesList(0, false, "", false);


        //Vista
        return view('solicitudesRecibidas.nuevo',
            compact(
                'solicitudRecibida',
                'comunidades',
                'titulo'
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ValidateRulesSolicitudesRecibidas $request)
    {
        //Creamos una nueva instancia al modelo.
        $solicitudRecibida = new SolicitudesRecibidas();
        //Asignamos valores traidos del formulario.
        $solicitudRecibida->comunidad_id = \Request::input('comunidad_id');
        $solicitudRecibida->aceptada = \Request::input('aceptada');
        $solicitudRecibida->activo = \Request::input('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $solicitudRecibida->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('solicitudesRecibidas.create')->
                    with('mensaje', 'La solicitud está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('solicitudesRecibidas.index')->
                    with('mensaje', 'Nueva Solicitud error ' . $e->getCode());
            }
        }
        //Redireccionamos a Solicitudes Recibidas (index)
        return redirect('solicitudesRecibidas')->
        with('mensaje', 'La solicitud se ha creado satisfactoriamente.');
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
        //Título Vista
        $titulo = "Modificar Solicitud Recibida";
        $solicitudRecibida = SolicitudesRecibidas::find($id);
        $comunidad=Comunidades::getNombreComunidad($solicitudRecibida->comunidad_id);

        //Vista
        return view('solicitudesRecibidas.modificar',
            compact(
                'solicitudRecibida',
                'comunidad',
                'titulo'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, ValidateRulesSolicitudesRecibidas $request)
    {
        //Creamos una nueva instancia al modelo.
        $solicitudRecibida = SolicitudesRecibidas::find($id);
        $solicitudRecibida->aceptada = \Request::input('aceptada');
        $solicitudRecibida->activo = \Request::input('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $solicitudRecibida->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('solicitudesRecibidas.index')->
                    with('mensaje', 'La solicitud está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('solicitudesRecibidas.index')->
                    with('mensaje', 'Modificar Solicitud error ' . $e->getCode());
            }
        }
        //Redireccionamos a Solicitudes Recibidas (index)
        return redirect('solicitudesRecibidas')->
        with('mensaje', 'La solicitud ha sido modificada satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $solicitudRecibida = SolicitudesRecibidas::find($id);
        try {
            $solicitudRecibida->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('solicitudesRecibidas.index')->with('mensaje', 'La solicitud no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('solicitudesRecibidas.index')->with('mensaje', 'Eliminar solicitud error ' . $e->getCode());
            }
        }
        return redirect()->route('solicitudesRecibidas.index')
            ->with('mensaje', 'La solicitud ha sido eliminada correctamente.');
    }


    public function getCursillosSolicitudRecibida(Request $request)
    {

        $titulo="Listado de Cursillos";
        $comunidadId=$request->comunidad_id;
        $solicitudId=$request->solicitud_id;
        $comunidad=Comunidades::getNombreComunidad($comunidadId);

        $solicitudesRecibidasCursillos= SolicitudesRecibidasCursillos::getCursillosSolicitud($comunidadId, $solicitudId);

        return view("solicitudesRecibidas.verCursillos", compact('solicitudesRecibidasCursillos', 'titulo', 'comunidad', 'solicitudId'));
    }
}
