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

    public function enviar(Request $request)
    {
        $tipoEnvio = $request->get("modalidad");
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'), 0, false);
        $cursillos = Cursillos::getCursillosPDF($request->get('nuestrasComunidades'), $request->get('anyo'), $request->get('semana'));
        $numeroDestinatarios = count($destinatarios);
        //Configuración del listado html
        $listadoPosicionInicial = 43.5;
        $listadoTotal = 9;
        $listadoTotalRestoPagina = 40;
        $separacionLinea = 1.5;
        if (count($remitente) == 0 || $numeroDestinatarios == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasSolicitudes')->
            with('mensaje', 'No se puede realizar la operación, comprueba que exista remitente y/o destinatario/s  y/o curso/s');
        }
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];
        //PDF en múltiples páginas
        $multiplesPdf = \App::make('dompdf.wrapper');
        $multiplesPdfBegin = '<html lang="es">';
        $multiplesPdfContain = "";
        $multiplesPdfEnd = '</html>';

        //Ampliamos el tiempo de ejecución del servidor a 5 minutos.
        ini_set("max_execution_time", 500);
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
                    $logEnvios[] = ["Creado fichero adjunto para el email de solicitud de la comunidad " . $destinatario->comunidad, "", "floppy-saved", true];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el fichero adjunto para el email de la comunidad" . $destinatario->comunidad, "", "floppy-remove", false];
                }
                $esCarta = false;
                try {
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
                $logEnvios[] = $envio > 0 ? ["Enviado email de solicitud a la comunidad destinataria " . $destinatario->comunidad . " con dirección " . $destinatario->email_envio, "", "envelope", true] :
                    ["No se pudo enviar la solicitud a la comunidad destinataria " . $destinatario->comunidad . " con dirección " . $destinatario->email_envio, "", "envelope", false];
            } elseif ($tipoEnvio != 1 && (strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) == 0)) {
                $logEnvios[] = ["La comunidad remitente " . $remitente->comunidad . " carece de email", "", "envelope", false];
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
        if (count($destinatarios) > 1 && $tipoEnvio != 2) {
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
