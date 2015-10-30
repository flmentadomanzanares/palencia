<?php namespace Palencia\Http\Controllers;

use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;
use Palencia\Entities\Cursillos;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class PdfController extends Controller {

    public function getCursillos(Request $request)
    {
        $titulo = "Cursillos en el Mundo";

        $cursillos = Cursillos::getCursillosPorPaises($request);
        //dd($cursillos);
        $anyos = Cursillos::getAnyoCursillos();
        $semanas =Array();

        return view("pdf.listarCursillos", compact('cursillos', 'titulo', 'anyos', 'semanas'));

    }

    // Listado 'Cursillos en el Mundo'
    public function imprimirCursillos()
    {

        $year = null;
        $week = null;

        //Sesion para llevar los parámetros de year y week
        if (Session::has('imprimirCursillos')) {

            $year = Session::get('imprimirCursillos.year');
            $week = Session::get('imprimirCursillos.week');

        } else {

        }

        $titulo = "Cursillos en el Mundo";
        //$year ='2015';
        //$week ='34';
        $date = date('d-m-Y');
        $cursillos = Cursillos::listarCursillosPorPaises($year, $week);

       $view =  \View::make('pdf.imprimirCursillos', compact('cursillos', 'week', 'year','date', 'titulo'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('imprimirCursillos'); /* muestra en pantalla*/
        //return $pdf->download('invoice'); /* crea pdf en directorio descargas */
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
