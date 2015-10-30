<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Http\Requests;


use Illuminate\Http\Request;

class NuestrasRespuestasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Nuestras Respuestas";
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false);
        $restoComunidades = Comunidades::getComunidadesList(false,true, "Resto Comunidades.....",true);
        $anyos = Cursillos::getAnyoCursillosList();
        $semanas = Array();
        $cursillos = Cursillos::getCursillos($request);
        return view('nuestrasRespuestas.index',
            compact(
                'nuestrasComunidades',
                'restoComunidades',
                'cursillos',
                'anyos',
                'semanas',
                'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {/*
        $proyectos = Proyectos::select('proyectos.id', 'proyectos.titulo', 'proyectos.empresa_id', 'proyectos.activo',
            'proyectos.fecha_inicio', 'proyectos.fecha_final', 'proyectos.created_at',
            'proyectos.estadoProyecto','postulacionesTotales')->
        proyecto($miCategoria)->
        estadoProyecto($miEstado)->
        where('proyectos.fecha_inicio', "<=", $fechaActual)->
        where('proyectos.fecha_final', ">=", $fechaActual)->
        orderBy('proyectos.created_at', 'ASC')->
        orderBy('proyectos.titulo', 'ASC')->
        leftJoin(DB::raw("(SELECT DISTINCT  proyectos.id, COUNT(postulaciones_proyectos.proyecto_id) as postulacionesTotales ,postulaciones_proyectos.proyecto_id as postulacion
                        FROM postulaciones_proyectos, proyectos
                        WHERE proyectos.id = postulaciones_proyectos.proyecto_id
                        GROUP BY postulaciones_proyectos.proyecto_id
            ) postulaciones_proyectos") ,"proyectos.id", "=", 'postulacion')->
        paginate(3)->
        setPath('proyectosDemandados');*/
    }

    public function enviar(Request $request)
    {
        $remitente = Comunidades::getComunidadPDF($request->get('nuestrasComunidades'));
        $destinatirios = Comunidades::getComunidadPDF($request->get('restoComunidades'),false);
        $cursillos = Cursillos::getCursillosPDF($request->get('restoComunidades'), $request->get('anyo'), $request->get('semana'));

        dd($destinatirios);
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuesta', compact('cursillos'), [], 'UTF-8')->save('pruebaok.pdf');
    }
}
