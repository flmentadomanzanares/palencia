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
        $titulo = "Pa&iacute;ses";

        //Vamos al indice y creamos una paginación de 8 elementos y con ruta categorias
        $paises = Paises::getPaises($request, 8);
        return view("paises.index", compact("paises", "titulo"));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $titulo = "Nuevo Pa&iacute;s";
        $pais = new Paises;
        return view("paises.nuevo", compact("pais", "titulo"));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */

    //si no se incluye el control de reglas de validación como argumento, el método crea paises vacíos. con store()
    public function store(ValidateRulesPaises $request)
    {
        $pais = new Paises; //Creamos instancia al modelo
        $pais->pais = strtoupper($request->get("pais")); //Asignamos el valor al campo.
        try {
            $pais->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route("paises.create")
                        ->with("mensaje", "El pa&iacute;s " . $pais->pais . " est&aacute; ya dado de alta.");
                    break;
                default:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "Nuevo pa&iacute;s error " . $e->getCode());
            }
        }
        return redirect("paises")
            ->with("mensaje", "El pa&iacute;s " . $pais->pais . " se ha creado satisfactoriamente.");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $titulo = "Modificar Pa&iacute;s";
        $pais = Paises::find($id);
        if ($pais == null) {
            return Redirect('paises')->with('mensaje', 'No se encuentra el pa&iacute;s seleccionado.');
        }
        return view('paises.modificar', compact('pais', 'titulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, ValidateRulesPaises $request)
    {
        $pais = Paises::find($id);
        if ($pais == null) {
            return Redirect('paises')->with('mensaje', 'No se encuentra el pa&iacute;s seleccionado.');
        }
        $pais->pais = strtoupper($request->get("pais"));
        if (\Auth::user()->roles->peso >= config("opciones.roles.administrador")) {
            $pais->activo = $request->get("activo");
        }
        try {
            $pais->save();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                default:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "Modificar pa&iacute;s error " . $e->getCode());
            }
        }
        return redirect()->route("paises.index")
            ->with("mensaje", $pais->pais . " se ha modificado satisfactoriamente.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $pais = Paises::find($id);
        if ($pais == null) {
            return Redirect('paises')->with('mensaje', 'No se encuentra el pa&iacute;s seleccionado.');
        }
        try {
            $pais->delete();
        } catch (\Exception $e) {
            switch ($e->getCode()) {
                case 23000:
                    return redirect()->route("paises.index")
                        ->with("mensaje", $pais->pais . " no se puede eliminar al tener provincias asociadas. ");
                    break;
                default:
                    return redirect()->route("paises.index")
                        ->with("mensaje", "Eliminar pa&iacute;s error " . $e->getCode());
            }
        }
        return redirect()->route("paises.index")
            ->with("mensaje", $pais->pais . " se ha borrado correctamente.");
    }
}