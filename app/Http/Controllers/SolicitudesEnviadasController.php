<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\SolicitudesEnviadasCursillos;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesSolicitudesEnviadas;

class SolicitudesEnviadasController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Sus Respuestas";
        $solicitudesEnviadas = SolicitudesEnviadas::getSolicitudesEnviadas($request);
        $comunidades = SolicitudesEnviadas::getComunidadesSolicitudesEnviadasList();
        return view("solicitudesEnviadas.index", compact('solicitudesEnviadas', 'titulo', 'comunidades'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
    {
	//Título Vista
        $titulo = "Nueva Solicitud Enviada";
        $solicitudEnviada = new SolicitudesEnviadas();
       /* $comunidadesPropias = Comunidades::getComunidadesList(1, false, "", true);*/
        $comunidades = Comunidades::getComunidadesList(0, false, "", false);


        //Vista
        return view('solicitudesEnviadas.nuevo',
            compact(
                'solicitudEnviada',
                'comunidades',
                'titulo'
            ));
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ValidateRulesSolicitudesEnviadas $request)
	{
        //Creamos una nueva instancia al modelo.
        $solicitudEnviada = new SolicitudesEnviadas();
        //Asignamos valores traidos del formulario.
        $solicitudEnviada->comunidad_id = \Request::input('comunidad_id');
        $solicitudEnviada->aceptada = \Request::input('aceptada');
        $solicitudEnviada->activo = \Request::input('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $solicitudEnviada->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('solicitudesEnviadas.create')->
                    with('mensaje', 'La solicitud está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('solicitudesEnviadas.index')->
                    with('mensaje', 'Nueva Solicitud error ' . $e->getCode());
            }
        }
        //Redireccionamos a Solicitudes Enviadas (index)
        return redirect('solicitudesEnviadas')->
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
        $titulo = "Modificar Solicitud Enviada";
        $solicitudEnviada = SolicitudesEnviadas::find($id);
        if ($solicitudEnviada == null) {
            return Redirect('solicitudesEnviadas')->with('mensaje', 'No se encuentra la solicitud seleccionada.');
        }
        $comunidad=Comunidades::getNombreComunidad($solicitudEnviada->comunidad_id);
        //Vista
        return view('solicitudesEnviadas.modificar',
            compact(
                'solicitudEnviada',
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
	public function update($id, ValidateRulesSolicitudesEnviadas $request)
	{
        //Creamos una nueva instancia al modelo.
        $solicitudEnviada = SolicitudesEnviadas::find($id);
        if ($solicitudEnviada == null) {
            return Redirect('solicitudesEnviadas')->with('mensaje', 'No se encuentra la solicitud seleccionada.');
        }
        $solicitudEnviada->aceptada = \Request::input('aceptada');
        $solicitudEnviada->activo = \Request::input('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $solicitudEnviada->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('solicitudesEnviadas.index')->
                    with('mensaje', 'La solicitud está ya dada de alta.');
                    break;
                default:
                    return redirect()->
                    route('solicitudesEnviadas.index')->
                    with('mensaje', 'Modificar Solicitud error ' . $e->getCode());
            }
        }
        //Redireccionamos a Solicitudes Enviadas (index)
        return redirect('solicitudesEnviadas')->
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
        $solicitudEnviada = SolicitudesEnviadas::find($id);
        if ($solicitudEnviada == null) {
            return Redirect('solicitudesEnviadas')->with('mensaje', 'No se encuentra la solicitud seleccionada.');
        }
        try {
            $solicitudEnviada->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('solicitudesEnviadas.index')->with('mensaje', 'La solicitud no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('solicitudesEnviadas.index')->with('mensaje', 'Eliminar solicitud error ' . $e->getCode());
            }
        }
        return redirect()->route('solicitudesEnviadas.index')
            ->with('mensaje', 'La solicitud ha sido eliminada correctamente.');
	}

    public function getCursillosSolicitudEnviada(Request $request)
    {

        $titulo="Listado de Cursillos";
        $comunidadId=$request->comunidad_id;
        $solicitudId=$request->solicitud_id;
        $comunidad=Comunidades::getNombreComunidad($comunidadId);
        $solicitudesEnviadasCursillos= SolicitudesEnviadasCursillos::getCursillosSolicitud($comunidadId, $solicitudId, $request);

        return view("solicitudesEnviadas.verCursillos", compact('solicitudesEnviadasCursillos', 'titulo', 'comunidad', 'solicitudId'));
    }

}
