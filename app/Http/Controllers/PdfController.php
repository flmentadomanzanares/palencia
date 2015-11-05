<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Http\Requests;
use Palencia\Http\Controllers\Controller;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;

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
    public function getCursillos()
    {
        $titulo = "Cursillos en el Mundo";

        $anyos = Cursillos::getAnyoCursillosList();
        $semanas = Array();

        return view("pdf.listarCursillos",
            compact('titulo',
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
    public function imprimirCursillos()
    {

        $titulo = "Cursillos en el Mundo";

        $anyo = \Request::input('anyo');
        $semana = \Request::input('semana');
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

    /*******************************************************************
     *
     *  Listado "Intendencia para Clausura"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getComunidades()
    {
        $titulo = "Intendencia para Clausura";
        $solicitudEnviada = new SolicitudesEnviadas();
        $anyos = Cursillos::getAnyoCursillosList();
        $cursillos = Cursillos::getCursillosList();

        return view("pdf.listarComunidades", compact('solicitudEnviada', 'anyos', 'cursillos', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Intendencia para Clausura"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirComunidades()
    {

        $titulo = "Intendencia para clausura";

        $solicitudEnviada = new SolicitudesEnviadas();

        $anyo = \Request::input('anyo');
        $idCursillo = \Request::input('cursillo_id');

        $cursillo = Cursillos::getNombreCursillo((int)$idCursillo);
        $date = date('d-m-Y');
        $comunidades = SolicitudesEnviadas::imprimirIntendenciaClausura($anyo, $idCursillo);

        if ($anyo == 0 || $idCursillo == 0) {

            return redirect('intendenciaClausura')->
            with('mensaje', 'Debe seleccionar un año y un cursillo.');

        } else {


            $view = \View::make('pdf.imprimirComunidades',
                compact('comunidades',
                    'cursillo',
                    'anyo',
                    'date',
                    'titulo'))
                ->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('imprimirCursillos');

        }

    }
}
