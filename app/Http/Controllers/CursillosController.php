<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Palencia\Entities\Cursillos;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;
use Palencia\Entities\Comunidades;

//Validación
use Palencia\Http\Requests\ValidateRulesCursillos;

class CursillosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index(Request $request)
	{
        //Obtenemos los cursillos
        $cursillos = Cursillos::Select('cursillos.*')->orderBy('cursillo', 'ASC')->paginate(3)->setPath('cursillos');

        return view("cursillos.index", compact('cursillos'))->with('titulo', 'Listado de Cursillos');
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

        $cursillos = new Cursillos;

        // Array que contiene los valores del campo enum tipo_alumnos en la tabla Cursillos.
        $filtroEnumTipoAlumnos = Cursillos::getCursilloEnumValues('tipoAlumnos');

        // Array que contiene los valores del campo enum tipo_cursillo en la tabla Cursillos.
        $filtroEnumTipoCursillo = Cursillos::getCursilloEnumValues('tipoCursillo');

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

        //Obtenemos las comunidades activas y ordenadas alfabéticamente.
        $comunidades = Comunidades::orderBy("comunidad")->
        where("activo",true)->
        orderBy("comunidad")->
        lists('comunidad', 'id');

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
        $cursillos = new Cursillos;

        //Asignamos valores traidos del formulario.
        $cursillos->cursillo = \Request::input('titulo');
        $cursillos->fecha_inicio = $this->ponerFecha(\Request::input('fecha_inicio'));
        $cursillos->fecha_final = $this->ponerFecha(\Request::input('fecha_final'));
        $cursillos->descripcion = \Request::input('descripcion');
        $cursillos->comunidad_id = \Request::input('comunidad_id');
        $cursillos->tipoAlumnos = \Request::input('tipoAlumnos');
        $cursillos->tipoCursillo = \Request::input('tipoAlumnos');
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
                    with('mensaje', 'El cursillo ' . \Request::input('cursillo') . ' está ya dado de alta.');
                    break;
                default:
                    return redirect()->
                    route('cursillos.index')->
                    with('mensaje', 'Nuevo Cusillo error ' . $e->getCode());
            }
        }
        //Redireccionamos a Cursillos (index)
        return redirect('cursillos')->
        with('mensaje', 'El Cursillo ' . $cursillos->cursillo . ' creado satisfactoriamente.');
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
        $cursillos = Cursillos::find($id);

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
