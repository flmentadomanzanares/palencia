<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Http\Requests;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Paises;

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

        if ($anyo == 0 || $semana == 0) {

            return redirect('cursillosPaises')->
            with('mensaje', 'Debe seleccionar un año y una semana.');

        } else {
            $view = \View::make('pdf.imprimirCursillos',
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
        $cursillos = new Cursillos();
        $cursillos->fecha_inicio = $this->ponerFecha(date("d-m-Y"));
        $cursillos->fecha_final = $this->ponerFecha(date("d-m-Y"));

        /*$anyos = Cursillos::getAnyoCursillosList();
        $cursillos = Cursillos::getCursillosList();*/

        return view("pdf.listarComunidades", compact('solicitudEnviada', 'cursillos', 'titulo'));
       /* return view("pdf.listarComunidades", compact('solicitudEnviada', 'anyos', 'cursillos', 'titulo'));*/

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

        $cursillos = new Cursillos();
        $fecha_inicio = $cursillos->fecha_inicio = $this->ponerFecha(\Request::input('fecha_inicio'));
        $fecha_final = $cursillos->fecha_final = $this->ponerFecha(\Request::input('fecha_final'));

        $solicitudEnviada = new SolicitudesEnviadas();

        /*$anyo = \Request::input('anyo');
        $idCursillo = \Request::input('cursillo_id');

        $cursillo = Cursillos::getNombreCursillo((int)$idCursillo);*/
        $date = date('d-m-Y');
       /* $comunidades = SolicitudesEnviadas::imprimirIntendenciaClausura($anyo, $idCursillo);*/
        $comunidades = SolicitudesEnviadas::imprimirIntendenciaClausura($fecha_inicio, $fecha_final);


       /* if ($anyo == 0 || $idCursillo == 0) {

            return redirect('intendenciaClausura')->
            with('mensaje', 'Debe seleccionar un año y un cursillo.');

        } else {


            $view = \View::make('pdf.imprimirComunidades',
                compact('comunidades',
                    'cursillo',
                    'anyo',
                    'date',
                    'titulo'))
                ->render();*/
        $view = \View::make('pdf.imprimirComunidades',
            compact('comunidades',
                'anyo',
                'date',
                'titulo'))
            ->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('imprimirComunidades');

        }



    /*******************************************************************
     *
     *  Listado "Secretariado"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getSecretariado()
    {
        $titulo = "Secretariado";
        $comunidad = new Comunidades();
        $comunidades = Comunidades::getComunidadesAll();


        return view("pdf.listarSecretariado", compact('comunidades', 'comunidad', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariado"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirSecretariado()
    {

        $titulo = "Secretariado ";

        $comunidad = new Comunidades();

        $idComunidad = \Request::input('comunidad');

        $secretariado = Comunidades::getNombreComunidad((int)$idComunidad);
        $date = date('d-m-Y');
        $solicitudesRecibidas = SolicitudesRecibidas::getSolicitudesComunidad($idComunidad);
        $solicitudesEnviadas = SolicitudesEnviadas::getSolicitudesComunidad($idComunidad);


        if ($idComunidad == 0) {

            return redirect('secretariado')->
            with('mensaje', 'Debe seleccionar un secretariado.');

        } else {


            $view = \View::make('pdf.imprimirSecretariado',
                compact('secretariado',
                    'solicitudesEnviadas',
                    'solicitudesRecibidas',
                    'date',
                    'titulo'))
                ->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('imprimirSecretariado');

        }

    }

    /*******************************************************************
     *
     *  Listado "Secretariados por Paises"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getSecretariadosPais()
    {
        $titulo = "Secretariados por Pais";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesList();


        return view("pdf.listarSecretariadosPais", compact('comunidades', 'paises', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariados por Paises"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirSecretariadosPais()
    {

        $titulo = "Secretariados de ";

        $comunidades = new Comunidades();

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);
        $date = date('d-m-Y');
        $comunidades = Comunidades::imprimirSecretariadosPais($idPais);

        if ($idPais == 0) {

            return redirect('secretariadosPais')->
            with('mensaje', 'Debe seleccionar un país.');

        } else {


            $view = \View::make('pdf.imprimirSecretariadosPais',
                compact('comunidades',
                    'pais',
                    'date',
                    'titulo'))
                ->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('imprimirSecretariadosPais');

        }

    }

    private function ponerFecha($date)
    {
        $partesFecha = date_parse_from_format('d/m/Y', $date);
        $fecha = mktime(0, 0, 0, $partesFecha['month'], $partesFecha['day'], $partesFecha['year']);
        return date('Y-m-d H:i:s', $fecha);
    }
}
