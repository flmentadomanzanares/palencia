<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\Paises;
use Palencia\Entities\SolicitudesEnviadas;
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

        $anyos = SolicitudesRecibidasCursillos::getAnyoSolicitudesRecibidasList(false);
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
        $cursillos = new Cursillos();
        $cursillos->fecha_inicio = $this->ponerFecha(date("d-m-Y"));
        $cursillos->fecha_final = $this->ponerFecha(date("d-m-Y"));

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
        $cursillos = new Cursillos();
        $fecha_inicio = $cursillos->fecha_inicio = $this->ponerFecha(\Request::input('fecha_inicio'));
        $fecha_final = $cursillos->fecha_final = $this->ponerFecha(\Request::input('fecha_final'));
        $date = date('d-m-Y');
        $fichero = 'intendenciaClausura' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = SolicitudesEnviadasCursillos::imprimirIntendenciaClausura($fecha_inicio, $fecha_final);

        //Configuración del listado html
        $listadoPosicionInicial = 6;
        $listadoTotal = 23;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirComunidades',
            compact('comunidades',
                'anyo',
                'date',
                'titulo',
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
        $titulo = "Actividad con un Secretariado";
        $comunidad = new Comunidades();
        $comunidades = Comunidades::getComunidadesAll();
        $anyos = Cursillos::getTodosMisAnyosCursillosList(false);

        return view("pdf.listarSecretariado", compact('comunidades', 'comunidad', 'titulo', 'anyos'));
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
        $anyo = \Request::input('anyo');

        $secretariado = Comunidades::getNombreComunidad((int)$idComunidad);
        $date = date('d-m-Y');
        $fichero = 'secretariado' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $solicitudesRecibidas = SolicitudesRecibidasCursillos::getSolicitudesComunidad($anyo, $idComunidad);
        $solicitudesEnviadas = SolicitudesEnviadasCursillos::getSolicitudesComunidad($anyo, $idComunidad);

        //Configuración del listado html
        $listadoPosicionInicial = 8;
        $listadoTotal = 22;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idComunidad == 0 || $anyo == 0) {

            return redirect('secretariado')->
            with('mensaje', 'Debe seleccionar un año y un secretariado.');

        } else {

            $pdf = \App::make('dompdf.wrapper');
            $view = \View::make('pdf.imprimirSecretariado',
                compact('secretariado',
                    'solicitudesEnviadas',
                    'solicitudesRecibidas',
                    'date',
                    'titulo',
                    'anyo',
                    'listadoPosicionInicial',
                    'listadoTotal',
                    'listadoTotalRestoPagina',
                    'separacionLinea'
                ))->render();
            $pdf->loadHTML($view);
            $pdf->output();
            return $pdf->download($fichero . '.pdf');
        }


    }

    /*******************************************************************
     *
     *  Listado "Secretariados Activos por Paises"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getSecretariadosPais()
    {
        $titulo = "Secretariados Colaboradores Activos por Pais";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesColaboradores();


        return view("pdf.listarSecretariadosPais", compact('comunidades', 'paises', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariados Activos por Paises"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirSecretariadosPais()
    {

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);
        $date = date('d-m-Y');
        $fichero = 'secretariadosPais' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirSecretariadosPais($idPais);

        //Configuración del listado html
        $listadoPosicionInicial = 13;
        $listadoTotal = 20;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idPais == 0) {

            $titulo = "Secretariados Colaboradores Activos de Todos los Países";

        } else {

            $titulo = "Secretariados Colaboradores Activos de " . $pais->pais;

        }

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

    /*******************************************************************
     *
     *  Listado "Secretariados Inactivos por Paises"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getSecretariadosPaisInactivos()
    {
        $titulo = "Secretariados Colaboradores Inactivos por Pais";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesColaboradores();


        return view("pdf.listarSecretariadosPaisInactivos", compact('comunidades', 'paises', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariados Inactivos por Paises"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirSecretariadosPaisInactivos()
    {

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);
        $date = date('d-m-Y');
        $fichero = 'secretariadosInactivosPais' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirSecretariadosPaisInactivos($idPais);

        //Configuración del listado html
        $listadoPosicionInicial = 13;
        $listadoTotal = 20;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idPais == 0) {

            $titulo = "Secretariados Colaboradores Inactivos de Todos los Países";

        } else {

            $titulo = "Secretariados Colaboradores Inactivos de " . $pais->pais;

        }

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirSecretariadosPaisInactivos',
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

    /*******************************************************************
     *
     *  Listado "Secretariados no colaboradores activos"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getNoColaboradores()
    {
        $titulo = "Secretariados No Colaboradores Activos";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesFromPaisIdToList();


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

            $titulo = "Secretariados No Colaboradores Activos de Todos los Países";

        } else {

            $titulo = "Secretariados No Colaboradores Activos de " . $pais->pais;

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

    /*******************************************************************
     *
     *  Listado "Secretariados no colaboradores inactivos"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getNoColaboradoresInactivos()
    {
        $titulo = "Secretariados No Colaboradores Inactivos";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesFromPaisIdToList();


        return view("pdf.listarNoColaboradoresInactivos", compact('comunidades', 'paises', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariados no colaboradores inactivos"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirNoColaboradoresInactivos()
    {

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);

        //Configuración del listado html
        $listadoPosicionInicial = 13;
        $listadoTotal = 20;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idPais == 0) {

            $titulo = "Secretariados No Colaboradores Inactivos de Todos los Países";

        } else {

            $titulo = "Secretariados No Colaboradores Inactivos de " . $pais->pais;

        }

        $date = date('d-m-Y');
        $fichero = 'secretariadosNoColaboradoresInactivos' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirSecretariadosNoColaboradoresInactivos($idPais);

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirNoColaboradoresInactivos',
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

    /*******************************************************************
     *
     *  Listado "Paises Activos"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirPaisesActivos()
    {

        $date = date('d-m-Y');
        $fichero = 'paisesActivos' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirPaisesActivos();

        //Configuración del listado html
        $listadoPosicionInicial = 10;
        $listadoTotal = 23;
        $listadoTotalRestoPagina = 27;
        $separacionLinea = 2.5;
        $titulo = "Paises Activos";

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirPaisesActivos',
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

    /*******************************************************************
     *
     *  Listado "Secretariados Colaboradores Sin Responder"
     *
     *  Función para recabar la informacion necesaria para el listado
     *
     *******************************************************************/
    public function getSecretariadosColaboradoresSinResponder()
    {
        $titulo = "Secretariados Colaboradores Sin Responder";
        $comunidades = new Comunidades();
        $paises = Paises::getPaisesColaboradores();


        return view("pdf.listarSecretariadosColaboradoresSinResponder", compact('comunidades', 'paises', 'titulo'));

    }

    /*******************************************************************
     *
     *  Listado "Secretariados Colaboradores Sin Responder"
     *
     *  Función para imprimir el listado con los parametros
     *  seleccionados
     *
     *******************************************************************/
    public function imprimirSecretariadosColaboradoresSinResponder()
    {

        $idPais = \Request::input('pais');

        $pais = Paises::getNombrePais((int)$idPais);
        $date = date('d-m-Y');
        $fichero = 'secretariadosColaboradoresSinResponder' . substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
        $comunidades = Comunidades::imprimirSecretariadosPaisConSolicitudesSinResponder($idPais);

        //Configuración del listado html
        $listadoPosicionInicial = 15;
        $listadoTotal = 19;
        $listadoTotalRestoPagina = 25;
        $separacionLinea = 2.5;

        if ($idPais == 0) {

            $titulo1 = "Secretariados Colaboradores Sin Responder";
            $titulo2 = "de Todos los Países";

        } else {

            $titulo1 = "Secretariados Colaboradores Sin Responder";
            $titulo2 = "de " . $pais->pais;


        }

        $pdf = \App::make('dompdf.wrapper');
        return $pdf->loadView('pdf.imprimirSecretariadosColaboradoresSinResponder',
            compact(
                'comunidades',
                'pais',
                'date',
                'titulo1',
                'titulo2',
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
