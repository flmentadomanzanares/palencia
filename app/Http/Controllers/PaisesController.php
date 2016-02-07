<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Paises;
use Palencia\Http\Requests;
use Palencia\Http\Requests\ValidateRulesPaises;

//Validación

class PaisesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Países";

        //Vamos al indice y creamos una paginación de 8 elementos y con ruta categorias
        $paises = Paises::getPaises($request);
        return view("paises.index", compact("paises", "titulo"));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo País";
        $paises = new Paises;
        return view("paises.nuevo", compact("paises", "titulo"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesPaises $request)
    {
        $paises = new Paises; //Creamos instancia al modelo

        $paises->pais = \Request::input("pais"); //Asignamos el valor al campo.
        try {
            $paises->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route("paises.create")
                        ->with("mensaje", "El país " . \Request::input("pais") . " está ya dado de alta.");
                    break;
                default:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "Nuevo país error " . $e->getCode());
            }
        }
        return redirect("paises")
            ->with("mensaje", "El país " . $paises->pais . " creado satisfactoriamente.");

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar País";
        $paises = Paises::find($id);
        if ($paises == null) {
            return Redirect('paises')->with('mensaje', 'No se encuentra el país seleccionado.');
        }
        return view('paises.modificar', compact('paises', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesPaises $request)
    {
        $paises = Paises::find($id);
        if ($paises == null) {
            return Redirect('paises')->with('mensaje', 'No se encuentra el país seleccionado.');
        }
        $paises->pais = \Request::input("pais");
        if (\Auth::user()->roles->peso >= config("opciones.roles.administrador")) {
            $paises->activo = \Request::input("activo");
        }
        try {
            $paises->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "Modificar país error " . $e->getCode());
            }
        }
        return redirect()->route("paises.index")
            ->with("mensaje", "País  modificado satisfactoriamente.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $paises = Paises::find($id);
        if ($paises == null) {
            return Redirect('paises')->with('mensaje', 'No se encuentra el país seleccionado.');
        }
        $paisNombre = $paises->pais;

        try {
            $paises->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "El país " . $paisNombre . " no se puede eliminar al tener registros asociados.");
                    break;
                default:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "Eliminar país error " . $e->getCode());
            }

        }

        return redirect()->route("paises.index")
            ->with("mensaje", "El país " . $paisNombre . " eliminado correctamente.");
    }
}