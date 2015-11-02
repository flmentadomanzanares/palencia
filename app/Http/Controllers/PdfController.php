<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;
use Palencia\Entities\Cursillos;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class PdfController extends Controller {

    /*******************************************************************
     *
     *  Listado "Cursillos en el Mundo"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getCursillos(Request $request)
    {
        $titulo = "Cursillos en el Mundo";

        $cursillos = SolicitudesRecibidas::getCursillosPorPaises($request);
        //dd($cursillos);
        $anyos = Cursillos::getAnyoCursillosList();
        $semanas = Array();

        return view("pdf.listarCursillos",
            compact('cursillos',
                'titulo',
                'anyos',
                'semanas'));

    }

    /*******************************************************************
     *
     *  Listado "Cursillos en el Mundo"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirCursillos(Request $request)
    {

        $titulo = "Cursillos en el Mundo";

        $anyo = $request->get('anyo');
        $semana = $request->get('semana');
        $date = date('d-m-Y');
        $cursillos = SolicitudesRecibidas::imprimirCursillosPorPaises($anyo, $semana);

        $view =  \View::make('pdf.imprimirCursillos',
            compact('cursillos',
                    'anyo',
                    'semana',
                    'date',
                    'titulo'))
            ->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('imprimirCursillos');


    }


    public function getComunidades(Request $request)
    {
        $titulo = "Intendencia para Clausura";

        $cursillos = Cursillos::getIntendenciaClausura($request);
        //dd($cursillos);
        $anyos = Cursillos::getAnyoCursillos();
        $semanas =Array();

        return view("pdf.listarComunidades", compact('cursillos', 'titulo', 'anyos', 'semanas'));

    }

}
