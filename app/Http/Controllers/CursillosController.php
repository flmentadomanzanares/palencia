<?php namespace Palencia\Http\Controllers;

use Carbon\Carbon;
use Palencia\Entities\TiposCursillos;
use Palencia\Entities\TiposParticipantes;
use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\Cursillos;
use Palencia\Entities\Comunidades;
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
        $titulo = "Listado de cursillos";
        $cursillos = Cursillos::getCursillos($request);
        $anyos = Cursillos::getAnyoCursillos();
        $semanas =Array();
        return view("cursillos.index", compact('cursillos', 'titulo', 'anyos', 'semanas'));
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
        $cursillo->fecha_inicio = $this->ponerFecha(date("d-m-Y"));
        $cursillo->fecha_final = $this->ponerFecha(date("d-m-Y"));
        $tipos_participantes = TiposParticipantes::getTiposParticipantesList();
        $tipos_cursillos = TiposCursillos::getTiposCursillosList();
        $comunidades = Comunidades::getComunidadesList();
        //Vista
        return view('cursillos.nuevo',
            compact(
                'cursillo',
                'comunidades',
                'tipos_participantes',
                'tipos_cursillos',
                'titulo'
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ValidateRulesCursillos $request)
    {
        //Creamos una nueva instancia al modelo.
        $cursillos = new Cursillos();
        //Asignamos valores traidos del formulario.
        $cursillos->cursillo = \Request::input('cursillo');
        $cursillos->num_cursillo = \Request::input('num_cursillo');
        $cursillos->fecha_inicio = $this->ponerFecha(\Request::input('fecha_inicio'));
        $cursillos->fecha_final = $this->ponerFecha(\Request::input('fecha_final'));
        $cursillos->descripcion = \Request::input('descripcion');
        $cursillos->comunidad_id = \Request::input('comunidad_id');
        $cursillos->tipo_participante_id = \Request::input('tipo_participante_id');
        $cursillos->tipo_cursillo_id = \Request::input('tipo_cursillo_id');
        $cursillos->activo = \Request::input('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $cursillos->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('cursillos.create')->
                    with('mensaje', 'El cursillo está ya dado de alta.');
                    break;
                default:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'Nuevo Cusillo error ' . $e->getCode());
            }
        }
        //Redireccionamos a Cursillos (index)
        return redirect('cursillos')->
        with('mensaje', 'El Cursillo creado satisfactoriamente.');
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
        $cursillo = Cursillos::getCursillo($id);
        return view('cursillos.ver',
            compact(
                'cursillo',
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
        $titulo = "Modificar Cursillo";
        $cursillo = Cursillos::find($id);
        $tipos_participantes = TiposParticipantes::getTiposParticipantesList();
        $tipos_cursillos = TiposCursillos::getTiposCursillosList();
        $comunidades = Comunidades::getComunidadesList();
        //Vista
        return view('cursillos.modificar',
            compact(
                'cursillo',
                'comunidades',
                'tipos_participantes',
                'tipos_cursillos',
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
        $cursillo->cursillo = \Request::input('cursillo');
        $cursillo->num_cursillo = \Request::input('num_cursillo');
        $cursillo->fecha_inicio = $this->ponerFecha(\Request::input('fecha_inicio'));
        $cursillo->fecha_final = $this->ponerFecha(\Request::input('fecha_final'));
        $cursillo->descripcion = \Request::input('descripcion');
        $cursillo->comunidad_id = \Request::input('comunidad_id');
        $cursillo->tipo_participante_id = \Request::input('tipo_participante_id');
        $cursillo->tipo_cursillo_id = \Request::input('tipo_cursillo_id');
        $cursillo->activo = \Request::input('activo');
        //Intercepción de errores
        try {
            //Guardamos Los valores
            $cursillo->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'El cursillo está ya dado de alta.');
                    break;
                default:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'Modificar Cusillo error ' . $e->getCode());
            }
        }
        //Redireccionamos a Cursillos (index)
        return redirect('cursillos')->
        with('mensaje', 'El Cursillo ha sido modificado satisfactoriamente.');
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
        try {
            $cursillo->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route('cursillos.index')->with('mensaje', 'El cursillo no se puede eliminar al tener registros asociados.');
                    break;
                default:
                    return redirect()->route('cursillos.index')->with('mensaje', 'Eliminar cursillo error ' . $e->getCode());
            }
        }
        return redirect()->route('cursillos.index')
            ->with('mensaje', 'El cursillo ha sido eliminado correctamente.');
    }

    private function ponerFecha($date)
    {
        $partesFecha = date_parse_from_format('d/m/Y', $date);
        $fecha = mktime(0, 0, 0, $partesFecha['month'], $partesFecha['day'], $partesFecha['year']);
        return date('Y-m-d H:i:s', $fecha);
    }

    public function semanasTotales(Request $request)
    {
       if (\Request::ajax()) {
            $anyo = (int)\Request::input('anyo');
            $semanas = Cursillos::getSemanasCursillos($anyo);
            return $semanas;
        }
    }
}
