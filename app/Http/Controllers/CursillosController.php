<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\TiposParticipantes;
use Palencia\Http\Requests\ValidateRulesCursillos;

class CursillosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Cursillos";
        $comunidades = Comunidades::getComunidadesList(false, true, "Comunidad...", true);
        $cursillos = Cursillos::getCursillos($request, config("opciones.paginacion"));
        return view("cursillos.index", compact('comunidades', 'cursillos', 'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Título Vista
        $titulo = "Nuevo Cursillo";
        $cursillo = new Cursillos();
        $cursillo->cursillo = "CURSILLO DE CRISTIANDAD";
        $cursillo->fecha_inicio = $this->ponerFecha(date("d-m-Y"));
        $cursillo->fecha_final = $this->ponerFecha(date("d-m-Y"));
        $tipos_participantes = TiposParticipantes::getTiposParticipantesList();
        $comunidades = Comunidades::getComunidadesColaboradoras();
        //Vista
        return view('cursillos.nuevo',
            compact(
                'cursillo',
                'comunidades',
                'tipos_participantes',
                'titulo'
            ));
    }

    private function ponerFecha($date)
    {
        $partesFecha = date_parse_from_format('d/m/Y', $date);
        $fecha = mktime(12, 0, 0, $partesFecha['month'], $partesFecha['day'], $partesFecha['year']);
        return date('Y-m-d H:i:s', $fecha);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ValidateRulesCursillos $request)
    {
        //Creamos una nueva instancia al modelo.
        $cursillo = new Cursillos();
        //Asignamos valores traidos del formulario.
        $cursillo->cursillo = strtoupper($request->get('cursillo'));
        $cursillo->num_cursillo = $request->get('num_cursillo');
        $cursillo->fecha_inicio = $this->ponerFecha($request->get('fecha_inicio'));
        $cursillo->fecha_final = $this->ponerFecha($request->get('fecha_final'));
        $cursillo->descripcion = $request->get('descripcion');
        $cursillo->comunidad_id = $request->get('comunidad_id');
        $cursillo->tipo_participante_id = $request->get('tipo_participante_id');
        $cursillo->activo = $request->get('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $cursillo->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('cursillos.create')->
                    with('mensaje', 'El cursillo nº' . $cursillo->num_cursillo . ' est&aacute; ya dado de alta.');
                    break;
                default:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'Nuevo Cusillo error ' . $e->getCode());
            }
        }
        //Redireccionamos a Cursillos (index)
        return redirect('cursillos')->
        with('mensaje', 'El cursillo con nº' . $cursillo->num_cursillo . ' ha sido creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //Título de la vista.
        $titulo = "Detalles del cursillo";
        $esInicio = false;
        $cursillo = Cursillos::getCursillo($id);
        if (count($cursillo) == 0) {
            return redirect()->
            route('cursillos')->
            with('mensaje', 'El cursillo no est&aacute; dado de alta.');
        }
        return view('cursillos.ver',
            compact(
                'cursillo',
                'titulo',
                "esInicio"
            ));
    }

    public function verCursilloInicio($id)
    {
        //Título de la vista.
        $titulo = "Detalles del cursillo";
        $esInicio = true;
        $cursillo = Cursillos::getCursillo($id);
        if (count($cursillo) == 0) {
            return redirect()->
            route('inicio')->
            with('mensaje', 'El cursillo no est&aacute; dado de alta.');
        }
        return view('cursillos.ver',
            compact(
                'cursillo',
                'titulo',
                "esInicio"
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
        $titulo = "Modificar Cursillo";
        $cursillo = Cursillos::find($id);
        if ($cursillo == null)
            return redirect('cursillos')->with("No se ha encontrado el cursillo seleccionado.");
        $tipos_participantes = TiposParticipantes::getTiposParticipantesList();
        //Vista
        return view('cursillos.modificar',
            compact(
                'cursillo',
                'comunidades',
                'tipos_participantes',
                'titulo'
            ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesCursillos $request)
    {
        //Creamos una nueva instancia al modelo.
        $cursillo = Cursillos::find($id);
        if ($cursillo == null)
            return redirect('cursillos')->with("No se ha encontrado el cursillo seleccionado.");
        $cursillo->cursillo = strtoupper($request->get('cursillo'));
        $cursillo->num_cursillo = $request->get('num_cursillo');
        $cursillo->fecha_inicio = $this->ponerFecha($request->get('fecha_inicio'));
        $cursillo->fecha_final = $this->ponerFecha($request->get('fecha_final'));
        $cursillo->descripcion = $request->get('descripcion');
        //$cursillo->comunidad_id = $request->get('comunidad_id');
        $cursillo->tipo_participante_id = $request->get('tipo_participante_id');
        $cursillo->esSolicitud = $request->get('esSolicitud');
        $cursillo->esRespuesta = $request->get('esRespuesta');
        $cursillo->activo = $request->get('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $cursillo->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'El cursillo est&aacute; ya dado de alta.');
                    break;
                default:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'Modificar Cusillo error ' . $e->getCode());
            }
        }
        //Redireccionamos a Cursillos (index)
        return redirect('cursillos')->
        with('mensaje', 'El cursillo con nº' . $cursillo->num_cursillo . ' ha sido modificado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $cursillo = Cursillos::find($id);
        if ($cursillo == null)
            return redirect('cursillos')->with("No se ha encontrado el cursillo seleccionado.");
        try {
            $solicitudRecibidaCursillos = null;
            DB::transaction(function () use ($cursillo) {
                /*Eliminamos el cursillo en las solicitudes recibidas*/
                $solicitudRecibidaCursillos = DB::table('solicitudes_recibidas_cursillos')
                    ->where('cursillo_id', '=', $cursillo->id);

                if ($solicitudRecibidaCursillos->count() > 0) {
                    $solicitudRecibidaSolicitudId = $solicitudRecibidaCursillos->first()->solicitud_id;
                    $solicitudRecibidaCursillos->delete();

                    $solicitudRecibidaCursillosSolicitudId = DB::table('solicitudes_recibidas_cursillos')
                        ->where('solicitud_id', '=', $solicitudRecibidaSolicitudId);

                    if ($solicitudRecibidaCursillosSolicitudId->count() == 0) {
                        DB::table('solicitudes_recibidas')
                            ->where('id', '=', $solicitudRecibidaSolicitudId)->delete();
                    }
                }

                /*Eliminamos el cursillo en las solicitudes enviadas*/
                $solicitudEnviadaCursillos = DB::table('solicitudes_enviadas_cursillos')
                    ->where('cursillo_id', '=', $cursillo->id);
                if ($solicitudEnviadaCursillos->count() > 0) {
                    $solicitudEnviadaSolicitudId = $solicitudEnviadaCursillos->first()->solicitud_id;
                    $solicitudEnviadaCursillos->delete();

                    $solicitudEnviadaCursillosSolicitudId = DB::table('solicitudes_enviadas_cursillos')
                        ->where('solicitud_id', '=', $solicitudEnviadaSolicitudId);
                    if ($solicitudEnviadaCursillosSolicitudId->count() == 0) {
                        DB::table('solicitudes_enviadas')
                            ->where('id', '=', $solicitudEnviadaSolicitudId)->delete();
                    }
                }
                $cursillo->delete();
            });
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('cursillos.index')->with('mensaje', 'El cursillo con nº' . $cursillo->num_cursillo . ' no se puede eliminar al haber sido procesado.');
                    break;
                default:
                    return redirect()->route('cursillos.index')->with('mensaje', 'Eliminar cursillo error ' . $e->getMessage());
            }
        }
        return redirect()->route('cursillos.index')
            ->with('mensaje', 'El cursillo con nº' . $cursillo->num_cursillo . ' ha sido eliminado correctamente.');
    }

    public function semanasTotales(Request $request)
    {
        if (\Request::ajax()) {
            $anyo = $request->get('anyo');
            $comunidad = $request->get('comunidad');
            $semanas = Cursillos::getSemanasCursillos($anyo, $comunidad);
            return $semanas;
        }
    }

    public function fechasInicioCursosSolicitud(Request $request)
    {
        if (\Request::ajax()) {
            $anyo = $request->get('anyo');
            $comunidad = $request->get('comunidad');
            $fechasInicio = Cursillos::getFechasInicioCursillos($anyo, $comunidad, 1);
            return $fechasInicio;
        }
    }

    public function fechasInicioCursosResultado(Request $request)
    {
        if (\Request::ajax()) {
            $anyo = $request->get('anyo');
            $comunidadPropia = $request->get('comunidadPropia');
            $comunidadNoPropia = $request->get('comunidadNoPropia');
            $fechaInicio = Cursillos::getFechasInicioCursillos($anyo, $comunidadNoPropia, 0);
            return $fechaInicio;
        }
    }

    public function listadoCursillosSolicitudes(Request $request)
    {
        if (\Request::ajax()) {
            $anyo = $request->get('anyo');
            $comunidad = $request->get('comunidad');
            $esSolicitudAnterior = $request->get('esSolicitudAnterior') ? $request->get('esSolicitudAnterior') : true;
            return Cursillos::getTodosMisCursillos($comunidad, $anyo, filter_var($esSolicitudAnterior, FILTER_VALIDATE_BOOLEAN));
        }
    }

    public function listadoCursillosRespuestas(Request $request)
    {
        if (\Request::ajax()) {
            $comunidadesDestinatiras = $request->get('comunidadesDestinatarias');
            $anyo = $request->get('anyo');
            $esRespuestaAnterior = $request->get('esRespuestaAnterior');
            $tipoComunicacion = $request->get("tipoComunicacion");
            return Cursillos::getTodosLosCursillosMenosLosMios($comunidadesDestinatiras,
                $anyo,
                filter_var($esRespuestaAnterior, FILTER_VALIDATE_BOOLEAN),
                $tipoComunicacion
            );
        }
    }

    public function cursillosTotales(Request $request)
    {
        if (\Request::ajax()) {
            $comunidad = $request->get('comunidadId');
            return Cursillos::getTodosMisCursillosLista($comunidad);
        }
    }

    public function totalAnyos(Request $request)
    {
        if (\Request::ajax()) {
            $comunidades = $request->get('comunidadesIds');
            return Cursillos::GetAnyosCursillosList($comunidades, false, false);
        }
    }

    public function totalAnyosRespuestas(Request $request)
    {
        if (\Request::ajax()) {
            $comunidadesIds = $request->get('comunidadesIds');
            $incluirRespuestasAnteriores = $request->get('esRespuestaAnterior');
            return Cursillos::GetAnyosCursillosList($comunidadesIds, filter_var($incluirRespuestasAnteriores, FILTER_VALIDATE_BOOLEAN), false);
        }
    }

    public function totalAnyosRespuestaSolicitud(Request $request)
    {
        if (\Request::ajax()) {
            $comunidadPropia[] = $request->get('comunidadPropia');
            $comunidadNoPropia[] = $request->get('comunidadNoPropia');
            return Cursillos::getTodosMisAnyosCursillosResultadoSolicitudList($comunidadPropia, $comunidadNoPropia);
        }
    }
}
