<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\Paises;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Entities\SolicitudesEnviadasCursillos;
use Palencia\Entities\SolicitudesRecibidasCursillos;
use Palencia\Http\Requests;


class PdfController extends Controller
{

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

        $anyos = SolicitudesRecibidasCursillos::getAnyoSolicitudesRecibidasList();
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
        $fichero = 'cursillosMundo' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $cursillos = SolicitudesRecibidasCursillos::imprimirCursillosPorPaises($anyo, $semana);


        //Configuración del listado html
        $listadoPosicionInicial = 10;
        $listadoTotal = 22;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($anyo == 0 || $semana == 0) {

            return redirect('cursillosPaises')->
            with('mensaje', 'Debe seleccionar un año y una semana.');

        } else {

            $pdf = \App::make('dompdf.wrapper');
            return $pdf->loadView('pdf.imprimirCursillos',
                compact('cursillos',
                    'anyo',
                    'semana',
                    'date',
                    'titulo',
                    'listadoPosicionInicial',
                    'listadoTotal',
                    'listadoTotalRestoPagina',
                    'separacionLinea'
                ))
                ->download($fichero . '.pdf');
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
        $solicitudEnviada = new SolicitudesEnviadasCursillos();
        //$cursillos = new Cursillos();
        $cursillos=SolicitudesEnviadasCursillos::getNumeroCursillosList();

        return view("pdf.listarComunidades", compact('solicitudEnviada', 'cursillos', 'titulo'));

    }

    private function ponerFecha($date)
    {
        $partesFecha = date_parse_from_format('d/m/Y', $date);
        $fecha = mktime(0, 0, 0, $partesFecha['month'], $partesFecha['day'], $partesFecha['year']);
        return date('Y-m-d H:i:s', $fecha);
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
        /*$cursillos = new Cursillos();*/
        $idCursillo = \Request::input('num_cursillo');
        $date = date('d-m-Y');
        $fichero = 'intendenciaClausura' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = SolicitudesEnviadasCursillos::imprimirIntendenciaClausura($idCursillo);
        $comunidadPropia = Comunidades::getNombreComunidadPropia();
        $cursillo = Cursillos::getCursilloParaIntendencia($idCursillo);
        $titulo2 = "Del Cursillo Nº " . $cursillo->num_cursillo . " " . $cursillo->tipo_participante
            . " de la Diócesis de  " . ucwords(strtolower($comunidadPropia->comunidad));

        $listadoPosicionInicial = 10;
        $listadoTotal = 21;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirComunidades',
            compact('comunidades',
                    'anyo',
                    'date',
                    'titulo',
                    'titulo2',
                    'listadoPosicionInicial',
                    'listadoTotal',
                    'listadoTotalRestoPagina',
                    'separacionLinea'
                    ))
            ->download($fichero . '.pdf');
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

        //$comunidad = new Comunidades();

        $idComunidad = \Request::input('comunidad');

        $secretariado = Comunidades::getNombreComunidad((int)$idComunidad);
        $date = date('d-m-Y');
        $fichero = 'secretariado' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $solicitudesRecibidas = SolicitudesRecibidasCursillos::getSolicitudesComunidad($idComunidad);
        $solicitudesEnviadas = SolicitudesEnviadasCursillos::getSolicitudesComunidad($idComunidad);

        //Configuración del listado html
        $listadoPosicionInicial = 8;
        $listadoTotal = 22;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idComunidad == 0) {

            return redirect('secretariado')->
            with('mensaje', 'Debe seleccionar un secretariado.');

        } else {

            $pdf = \App::make('dompdf.wrapper');
            return $pdf->loadView('pdf.imprimirSecretariado',
                compact('secretariado',
                        'solicitudesEnviadas',
                        'solicitudesRecibidas',
                        'date',
                        'titulo',
                        'listadoPosicionInicial',
                        'listadoTotal',
                        'listadoTotalRestoPagina',
                        'separacionLinea'
                        ))
                ->download($fichero . '.pdf');

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
        //$paises = Paises::getPaisesList();
        $paises = Paises::getPaisesColaboradores();


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

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);
        $date = date('d-m-Y');
        $fichero = 'secretariadosPais' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirSecretariadosPais($idPais);

        //Configuración del listado html
        $listadoPosicionInicial = 15;
        $listadoTotal = 19;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idPais == 0) {

            return redirect('secretariadosPais')->
            with('mensaje', 'Debe seleccionar un país.');

        } else {

            $pdf = \App::make('dompdf.wrapper');
            return $pdf->loadView('pdf.imprimirSecretariadosPais',
                compact(
                    'comunidades',
                    'pais',
                    'date',
                    'titulo',
                    'listadoPosicionInicial',
                    'listadoTotal',
                    'separacionLinea',
                    'listadoTotalRestoPagina'
                ))
                ->download($fichero . '.pdf');

        }

    }

    /*******************************************************************
     *
     *  Listado "Secretariados no colaboradores"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getNoColaboradores()
    {
        $titulo = "Secretariados No Colaboradores";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesList();


        return view("pdf.listarNoColaboradores", compact('comunidades', 'paises', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariados no colaboradores"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirNoColaboradores()
    {

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);

        //Configuración del listado html
        $listadoPosicionInicial = 13;
        $listadoTotal = 20;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idPais == 0) {

            $titulo = "Secretariados No Colaboradores de Todos los Países";

        } else {

            $titulo = "Secretariados No Colaboradores de " . $pais->pais;

        }

        $date = date('d-m-Y');
        $fichero = 'secretariadosNoColaboradores' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirSecretariadosNoColaboradores($idPais);

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirNoColaboradores',
            compact(
                'comunidades',
                'date',
                'titulo',
                'listadoPosicionInicial',
                'listadoTotal',
                'separacionLinea',
                'listadoTotalRestoPagina'
            ))
            ->download($fichero . '.pdf');


    }

    public function semanasSolicitudesRecibidasCursillos(Request $request)
    {
        if (\Request::ajax()) {
            $anyo = $request->get('anyo');
            return SolicitudesRecibidasCursillos::getSemanasSolicitudesRecibidasCursillos($anyo);
        }
    }

    public function semanasSolicitudesEnviadas(Request $request)
    {

        if (\Request::ajax()) {
            $anyo = $request->get('anyo');
            return SolicitudesEnviadas::getSemanasSolicitudesEnviadas($anyo);
        }
    }
}
