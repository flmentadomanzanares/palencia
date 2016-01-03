<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\TiposComunicacionesPreferidas;
use Palencia\Http\Requests;

class NuestrasSolicitudesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Nuestras Solicitudes";
        $nuestrasComunidades = Comunidades::getComunidadesList(1, false, '', false);
        $restoComunidades = Comunidades::getComunidadesList(0, true, "Resto Comunidades.....", false);
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList("Cualquiera");
        $anyos = Array();
        $semanas = Array();
        $cursillos = array();
        return view('nuestrasSolicitudes.index',
            compact(
                'nuestrasComunidades',
                'restoComunidades',
                'cursillos',
                'anyos',
                'semanas',
                'tipos_comunicaciones_preferidas',
                'titulo'));
    }

    public function comprobarSolicitudes(Request $request)
    {

        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'), 0, false);
        $tipoEnvio = $request->get("modalidad");
        if ($tipoEnvio != 1) {
            $incidencias = array();
            foreach ($destinatarios as $idx => $destinatario) {
                if ($destinatario->comunicacion_preferida == "Email" && (strlen($destinatario->email_solicitud) == 0)) {
                    $incidencias[] = "La comunidad destinataria " . $destinatario->comunidad . " carece de email para el envío de nuestras solicitudes";
                }

            }
            if (count($incidencias) > 0) {
                $tipos_comunicaciones_preferidas = $request->get('modalidad');
                $nuestrasComunidades = $request->get('nuestrasComunidades');
                $anyos = $request->get('anyo');
                $semanas = $request->get('semana');
                $restoComunidades = $request->get('restoComunidades');
                $titulo = "Comunidades sin email de solicitud";
                return view('nuestrasSolicitudes.comprobacion',
                    compact('titulo',
                        'incidencias',
                        'tipos_comunicaciones_preferidas',
                        'nuestrasComunidades',
                        'anyos',
                        'semanas',
                        'restoComunidades'
                    ));
            }
        }
        return $this->enviar($request);
    }

    public function enviar(Request $request)
    {
        $tipoEnvio = $request->get("modalidad");
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'), 0, false);
        $cursillos = Cursillos::getCursillosPDF($request->get('nuestrasComunidades'), $request->get('anyo'), $request->get('semana'));
        $numeroDestinatarios = count($destinatarios);
        if (count($remitente) == 0 || $numeroDestinatarios == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasSolicitudes')->
            with('mensaje', 'No se puede realizar la operación, comprueba que exista remitente y/o destinatario/s  y/o curso/s');
        }
        //Configuración del listado html
        $listadoPosicionInicial = 43.5; //primera linea
        $listadoTotal = 9;  // nº lineas cursillo max primera pagina
        $listadoTotalRestoPagina = 40; // nº lineas cursillo resto de las paginas
        $separacionLinea = 1.5;

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];
        //PDF en múltiples páginas
        $destinatariosConCarta = 0;
        $multiplesPdf = \App::make('dompdf.wrapper');
        $multiplesPdfBegin = '<html lang="es">';
        $multiplesPdfContain = "";
        $multiplesPdfEnd = '</html>';

        //Ampliamos el tiempo de ejecución del servidor a 60 minutos.
        ini_set("max_execution_time", 6000);
        foreach ($destinatarios as $idx => $destinatario) {
            //Ruta Linux
            $separatorPath = "/";
            $path = "solicitudesCursillos";
            $archivo = $path . $separatorPath . "NS-" . date("d_m_Y", strtotime('now')) . '-' . $destinatario->pais . '-' . $destinatario->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            //Conversión a UTF
            $nombreArchivo = mb_convert_encoding($archivo, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
            $cursos = [];
            $esCarta = true;
            //Obtenemos Los cursos relacionados con la comunidad y creamos la línea de impresión para enviarla al template en memoria
            foreach ($cursillos as $idx => $cursillo) {
                if ($cursillo->comunidad_id == $remitente->id) {
                    $cursos[] = sprintf("Nº %'06s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                }
            }
            // $tipoEnvio si es distinto de carta , si su comunicación preferida es email y si tiene correo destinatario para el envío
            if ($tipoEnvio != 1 && (strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) > 0)) {
                //Nombre del archivo a adjuntar
                $archivoMail = "templatePDF" . $separatorPath . 'NS-' . $remitente->comunidad . '.pdf';
                //Conversión a UTF
                $nombreArchivoAdjuntoEmail = mb_convert_encoding($archivoMail, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
                $nombreArchivoAdjuntoEmail = str_replace(" ", "", $nombreArchivoAdjuntoEmail);
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    $view = \View::make('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                            , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                        ))->render();
                    $pdf->loadHTML($multiplesPdfBegin . $view . $multiplesPdfEnd);
                    $pdf->output();
                    $pdf->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = ["Creado fichero adjunto para la comunidad " . $destinatario->comunidad, "", "floppy-saved", true];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el fichero adjunto para la comunidad" . $destinatario->comunidad, "", "floppy-remove", false];
                }
                $esCarta = false;
                try {
                    $destinatario->email_envio = "franciscomentadomanzanares@gmail.com";
                    $envio = Mail::send('nuestrasSolicitudes.pdf.cartaSolicitudA1',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'),
                        function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                            $message->from($remitente->email_solicitud, $remitente->comunidad);
                            $message->to($destinatario->email_envio)->subject("Nuestra Solicitud");
                            $message->attach($nombreArchivoAdjuntoEmail);
                        });
                    unlink($nombreArchivoAdjuntoEmail);
                } catch (\Exception $e) {
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviada solicitud a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_envio, "", "envelope", true] :
                    ["No se pudo enviar la solicitud a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_envio, "", "envelope", false];
            } elseif ($tipoEnvio != 1 && (strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) == 0)) {
                $logEnvios[] = ["La comunidad destinataria " . $destinatario->comunidad . " no dispone de email de solicitud", "", "envelope", false];
            } elseif ($tipoEnvio != 2 && (strcmp($destinatario->comunicacion_preferida, "Email") != 0)) {
                try {

                    if (count($destinatarios) > 1) {
                        /* Crear carta por comunidad
                          $pdf = \App::make('dompdf.wrapper');
                          $pdf->loadView('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                              compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                                  , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                              ))->save($nombreArchivo);
                          $logEnvios[] = ["Creada carta de respuesta para " . $destinatario->comunidad, $nombreArchivo, "", true];
                        */
                        $view = \View::make('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                            compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                                , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                            ))->render();
                        $multiplesPdfContain .= $view;
                        $logEnvios[] = ["Creada carta de solicitud para la comunidad " . $destinatario->comunidad, "", "align-justify", true];
                        $destinatariosConCarta += 1;
                    } else {
                        $pdf = \App::make('dompdf.wrapper');
                        $view = \View::make('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                            compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                                , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                            ))->render();
                        $pdf->loadHTML($multiplesPdfBegin . $view . $multiplesPdfEnd);
                        $pdf->output();
                        return $pdf->download($nombreArchivo);
                    }
                } catch (\Exception $e) {
                    $logEnvios[] = ["No se ha podido crear la carta de solicitud para la comunidad " . $destinatario->comunidad, "", "align-justify", false];
                }
            }
        }
        if ($destinatariosConCarta > 0) {
            $pathTotalComunidadesCarta = $path . $separatorPath . "NS-" . date("d_m_Y", strtotime('now')) . '-' . "TotalComunidadesCarta.pdf";
            $multiplesPdf->loadHTML($multiplesPdfBegin . $multiplesPdfContain . $multiplesPdfEnd);
            $multiplesPdf->output();
            $multiplesPdf->save($pathTotalComunidadesCarta);
            $logEnvios[] = ["Creada cartas de solicitud  para todas las comunidades con modalidad de carta.", $pathTotalComunidadesCarta, "list-alt", true];
        }
        if (count($logEnvios) == 0) {
            $logEnvios[] = ["No hay operaciones que realizar.", "", "remove-sign", false];
        }

        $titulo = "Operaciones Realizadas";
        return view('nuestrasSolicitudes.listadoLog',
            compact('titulo', 'logEnvios'));

    }
}
