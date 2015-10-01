<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Palencia\Entities\Cursillos;
use Palencia\Entities\Localidades;
use Palencia\Entities\Paises;
use Palencia\Entities\Provincias;

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
                'titulo'
            ));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
