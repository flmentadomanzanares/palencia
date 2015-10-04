<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Illuminate\Http\Request;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;
use Palencia\Entities\Comunidades;

class ComunidadesController extends Controller {


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //Obtenemos los cursillos
        $titulo ="Listado de comunidades";
        $comunidades = Comunidades::getComunidades();

        return view("comunidades.index", compact('comunidades','titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Título Vista
        $titulo ="Nuevo Cursillo";

        $comunidades = new Comunidades;

        // Array que contiene los valores del campo enum tipo_alumnos en la tabla Cursillos.
        $filtroEnumTipoAlumnos = Comunidades::getCursilloEnumValues('tipoAlumnos');

        // Array que contiene los valores del campo enum tipo_cursillo en la tabla Comunidades.
        $filtroEnumTipoCursillo = Comunidades::getCursilloEnumValues('tipoCursillo');

        //Obtenemos los países activos.
        $paises = ['' => 'Elige País'] +
            Paises::orderBy('pais', 'ASC')->
            where("activo",true)->
            lists('pais', 'id');

        //Obtenemos las provincias activas.
        $provincias = ['' => 'Elige Provincia'] +
            Provincias::orderBy('provincia', 'ASC')->
            where ("activo",true)->
            lists('provincia', 'id');

        //Obtenemos las localidades activas.
        $localidades = ['' => 'Elige Localidad'] +
            Localidades::orderBy('localidad', 'ASC')->
            where ("activo",true)->
            lists('localidad', 'id');

        //Vista
        return view('cursillos.nuevo',
            compact(
                'cursillos',
                'comunidades',
                'paises',
                'provincias',
                'localidades',
                'usuarios',
                'filtroEnumTipoAlumnos',
                'filtroEnumTipoCursillo',
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
        $comunidades = new Comunidades;

        //Asignamos valores traidos del formulario.
        $comunidades->comunidad = \Request::input('titulo');
        $comunidades->fecha_inicio = $this->ponerFecha(\Request::input('fecha_inicio'));
        $comunidades->fecha_final = $this->ponerFecha(\Request::input('fecha_final'));
        $comunidades->descripcion = \Request::input('descripcion');
        $comunidades->comunidad_id = \Request::input('comunidad_id');
        $comunidades->tipoAlumnos = \Request::input('tipoAlumnos');
        $comunidades->tipoCursillo = \Request::input('tipoAlumnos');
        $comunidades->activo = \Request::input('activo');

        //Intercepción de errores
        try {
            //Guardamos Los valores
            $comunidades->save();

        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->
                    route('cursillos.create')->
                    with('mensaje', 'El cursillo ' . \Request::input('cursillo') . ' está ya dado de alta.');
                    break;
                default:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'Nuevo Cusillo error ' . $e->getCode());
            }
        }
        //Redireccionamos a Comunidades (index)
        return redirect('cursillos')->
        with('mensaje', 'El Cursillo ' . $comunidades->cursillo . ' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Título de la vista.
        $titulo = "Detalle Cursillo";

        //Obtiene los datos para el id seleccionado
        $comunidades = Comunidades::find($id);

        //Vamos a la vista "mostrar" pasandole los parametros seleccionados
        return view('cursillos.mostrar',
            compact(
                'cursillos',
                'titulo'
            ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
