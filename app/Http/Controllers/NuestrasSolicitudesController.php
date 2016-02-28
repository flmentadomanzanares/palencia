<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;
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
        $modalidad = $request->get("modalidad");
        $titulo = "Nuestras Solicitudes";
        //Comprobamos si el server permite modificar el tiempo de ejecución del script.
        $comprobarModoSeguro = set_time_limit(config('opciones.envios.seMaxtTimeAt'));
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false, '', false);
        $restoComunidades = Comunidades::getComunidadesList(false, $comprobarModoSeguro, "Enviar a todas las comunidades", false, $modalidad);
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList("Cualquiera");
        $anyos = array();
        $cursillos = array();
        return view('nuestrasSolicitudes.index',
            compact(
                'nuestrasComunidades',
                'restoComunidades',
                'cursillos',
                'anyos',
                'modalidad',
                'tipos_comunicaciones_preferidas',
                'titulo'));
    }

    public function comprobarSolicitudes(Request $request)
    {
        $tipoComunicacion = $request->get('modalidad');
        $destinatarios = Comunidades::getComunidadPDFSolicitudes($request->get('restoComunidades'), $tipoComunicacion);
        if ($tipoComunicacion != 1) {
            $incidencias = array();
            foreach ($destinatarios as $idx => $destinatario) {
                if ($destinatario->comunicacion_preferida == config("opciones.tipo.email") && (strlen($destinatario->email_solicitud) == 0)) {
                    $incidencias[] = "La comunidad destinataria " . $destinatario->comunidad . " carece de email para el envío de nuestras solicitudes";
                }
            }
            if (count($incidencias) > 0) {
                $tipos_comunicaciones_preferidas = $tipoComunicacion;
                $nuestrasComunidades = $request->get('nuestrasComunidades');
                $anyos = $request->get('anyo');
                $generarSusRespuestas = $request->get('generarSusRespuestas');
                $incluirSolicitudesAnteriores = $request->get('incluirSolicitudesAnteriores');
                $restoComunidades = $request->get('restoComunidades');
                $titulo = "Comunidades sin email de envío de solicitud";
                return view('nuestrasSolicitudes.comprobacion',
                    compact('titulo',
                        'incidencias',
                        'tipos_comunicaciones_preferidas',
                        'nuestrasComunidades',
                        'generarSusRespuestas',
                        'anyos',
                        'incluirSolicitudesAnteriores',
                        'restoComunidades'
                    ));
            }
        }
        return $this->enviar($request);
    }

    public function enviar(Request $request)
    {
        $modalidadComunicacion = $request->get("modalidad");
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        $destinatarios = Comunidades::getComunidadPDFSolicitudes($request->get('restoComunidades'), $modalidadComunicacion);
        $cursillos = Cursillos::getCursillosPDFSolicitud($request->get('nuestrasComunidades'), $request->get('anyo'), filter_var($request->get('incluirSolicitudesAnteriores'), FILTER_VALIDATE_BOOLEAN));
        $numeroDestinatarios = count($destinatarios);
        //Verificación
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
        $destinatariosConEmail = 0;
        $multiplesPdf = \App::make('dompdf.wrapper');
        $multiplesPdfBegin = '<html lang="es">';
        $multiplesPdfContain = "";
        $multiplesPdfEnd = '</html>';

        //Ampliamos el tiempo de ejecución del servidor a 60 minutos.
        ini_set("max_execution_time", config('opciones.envios.timeout'));

        //Obtenemos Los cursos relacionados con la comunidad y creamos la línea de impresión para enviarla al template en memoria
        $cursos = [];
        $cursosActualizados = [];
        $cursosActualizadosIds = [];
        $contadorCursosActualizados = 0;
        $comunidadesDestinatarias = [];
        foreach ($cursillos as $idx => $cursillo) {
            if ($cursillo->comunidad_id == $remitente->id) {
                $cursos[] = sprintf("Nº %'06s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                if (!$cursillo->esSolicitud || ($cursillo->esSolicitud && $request->get('generarSusRespuestas') && $request->get('incluirSolicitudesAnteriores'))) {
                    $cursosActualizados[] = sprintf("Cuso Nº %'06s de la comunidad %10s cambiado al estado de es solicitud.", $cursillo->num_cursillo, $remitente->comunidad);
                    $contadorCursosActualizados += 1;
                    $cursosActualizadosIds[] = $cursillo->id;
                }
            }
        }
        foreach ($destinatarios as $idx => $destinatario) {
            //Ruta Linux
            $separatorPath = "/";
            $path = "solicitudesCursillos";
            $archivo = $path . $separatorPath . "NS-" . date("d_m_Y", strtotime('now')) . '-' . $destinatario->pais . '-' . $destinatario->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            //Conversión a UTF
            $nombreArchivo = mb_convert_encoding($archivo, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
            $esCarta = true;
            //intentanmos modificar el tiempo de ejecución del script.
            set_time_limit(config('opciones.envios.seMaxtTimeAt'));
            // modalidadComunicacion si es distinto de carta , si su comunicación preferida es email y si tiene correo destinatario para el envío
            if ($modalidadComunicacion != 1 && (strcasecmp($destinatario->comunicacion_preferida, config("opciones.tipo.email")) == 0) && (strlen($destinatario->email_solicitud) > 0)) {
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
                    $logEnvios[] = ["Creado documento adjunto para la comunidad " . $destinatario->comunidad, "", "floppy-saved green icon-size-large"];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el documento adjunto para la comunidad" . $destinatario->comunidad, "", "floppy-remove red icon-size-large"];
                }
                $esCarta = false;
                try {
                    if (config("opciones.emailTestSender.active")) {
                        $destinatario->email_solicitud = config("opciones.emailTestSender.email");
                        $destinatario->email_envio = config("opciones.emailTestSender.email");
                    }
                    $envio = Mail::send('nuestrasSolicitudes.pdf.cartaSolicitudA1',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'),
                        function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                            $message->from($remitente->email_solicitud, $remitente->comunidad);
                            $message->to($destinatario->email_solicitud)->subject("Nuestra Solicitud");
                            $message->attach($nombreArchivoAdjuntoEmail);
                        });
                    $destinatariosConEmail += 1;
                    $comunidadesDestinatarias[] = [$destinatario->id, $destinatario->comunidad];
                    unlink($nombreArchivoAdjuntoEmail);
                } catch (\Exception $e) {
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviada solicitud a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_solicitud, "", "envelope green icon-size-large"] :
                    ["No se pudo enviar la solicitud a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_solicitud, "", "envelope red icon-size-large"];
            } elseif ($modalidadComunicacion != 1 && (strcasecmp($destinatario->comunicacion_preferida, config("opciones.tipo.email")) == 0) && (strlen($destinatario->email_solicitud) == 0)) {
                $logEnvios[] = ["La comunidad destinataria " . $destinatario->comunidad . " no dispone de email de solicitud", "", "envelope red icon-size-large"];
            } elseif ($modalidadComunicacion != 2 && (strcasecmp($destinatario->comunicacion_preferida, config("opciones.tipo.email")) != 0)) {
                try {
                    $view = \View::make('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                            , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                        ))->render();
                    $multiplesPdfContain .= $view;
                    $logEnvios[] = ["Creada carta de solicitud para la comunidad " . $destinatario->comunidad, "", "align-justify green icon-size-large"];
                    $destinatariosConCarta += 1;
                    $comunidadesDestinatarias[] = [$destinatario->id, $destinatario->comunidad];
                } catch (\Exception $e) {
                    $logEnvios[] = ["No se ha podido crear la carta de solicitud para la comunidad " . $destinatario->comunidad, "", "align-justify red icon-size-large"];
                }
            }
        }

        if ($destinatariosConCarta > 0) {
            $pathTotalComunidadesCarta = $path . $separatorPath . "NS-" . date("d_m_Y", strtotime('now')) . '-' . "TotalComunidadesCarta.pdf";
            $multiplesPdf->loadHTML($multiplesPdfBegin . $multiplesPdfContain . $multiplesPdfEnd);
            $multiplesPdf->output();
            $multiplesPdf->save($pathTotalComunidadesCarta);
            $logEnvios[] = ["Cartas creadas de solicitud.", $pathTotalComunidadesCarta, "list-alt green icon-size-large"];
        }
        if ($destinatariosConEmail > 0) {
            $logEnvios[] = [$destinatariosConEmail . ($destinatariosConEmail > 1 ? " emails enviados." : " email enviado"), "", "info-sign info icon-size-large"];
        }
        if ($destinatariosConCarta > 0) {
            $logEnvios[] = [$destinatariosConCarta . ($destinatariosConCarta > 1 ? " cartas creadas." : " carta creada."), "", "info-sign info icon-size-large"];
        }
        //Cambiamos de estado las solicitudes que no están como esSolicitud
        if (count($comunidadesDestinatarias) > 0 && count($cursosActualizadosIds) > 0) {
            if (Cursillos::setCursillosEsSolicitud($cursosActualizadosIds) == $contadorCursosActualizados && $contadorCursosActualizados > 0) {
                $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contadorCursosActualizados > 1 ? "s" : "") . " de la comunidad " . $remitente->comunidad . " ha"
                    . ($contadorCursosActualizados > 1 ? "n" : "") . " sido actualizado" . ($contadorCursosActualizados > 1 ? "s" : "") . " a solicitud realizada.", "", "info-sign info icon-size-large"];
            } elseif ($contadorCursosActualizados > 0) {
                $logEnvios[] = [count($cursosActualizados) . " Cursos de la comunidad " . $remitente->comunidad . " no se ha" . ($contadorCursosActualizados > 1 ? "n" : "") .
                    " podido actualizar como Solicitud.", "", "exclamation-sign red icon-size-large"];
            }
        }
        //Actualizamos las tablas de forma automática y añadimos los logs
        $logSolicitudesEnviadas = SolicitudesEnviadas::crearComunidadesCursillos($comunidadesDestinatarias, $cursosActualizadosIds);
        //Obtenemos el último registro del log generado.
        if (count($logSolicitudesEnviadas) > 0) {
            $logEnvios[] = $logSolicitudesEnviadas[count($logSolicitudesEnviadas) - 1];
        }

        //Creamos la cabecera del Log de archivo
        $logArchivo = array();
        $logArchivo[] = 'Fecha->' . date('d/m/Y H:i:s') . "\n";
        $logArchivo[] = 'Usuario->' . $request->user()->name . "\n";
        $logArchivo[] = 'Email->' . $request->user()->email . "\n";
        $logArchivo[] = 'Ip->' . $request->server('REMOTE_ADDR') . "\n";
        $logArchivo[] = '******************************************' . "\n";
        foreach ($logEnvios as $log) {
            $logArchivo[] = $log[0] . "\n";
        }
        if ($contadorCursosActualizados > 0) {
            foreach ($cursosActualizados as $log) {
                $logArchivo[] = $log . "\n";
            }
            foreach ($logSolicitudesEnviadas as $log) {
                $logArchivo[] = $log[0] . "\n";
            }
        }
        //Guardamos a archivo
        file_put_contents('logs/NS/NS_log_' . date('d_m_Y_H_i_s'), $logArchivo, true);

        $titulo = "Operaciones Realizadas";
        return view('nuestrasSolicitudes.listadoLog',
            compact('titulo', 'logEnvios'));

    }
}
