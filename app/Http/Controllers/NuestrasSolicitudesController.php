<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\TiposComunicacionesPreferidas;

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
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false, '', false);
        $restoComunidades = Array();
        $modalidad = $request->get("modalidad");
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList("Email + Carta");
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
        $incidencias = array();
        $conSusRespuestas = $request->get("incluirEnSusRespuestas");
        $comunidadesDestinatarias = $request->get('comunidadesDestinatarias');
        $comunidades = Comunidades::obtenerComunidadesPDF($comunidadesDestinatarias);
        $nuestrasComunidades = $request->get('nuestrasComunidades');
        $cursos = $request->get('cursos');

        if (count($comunidades) > 0) {
            foreach ($comunidades as $idx => $comunidad) {
                if (strtolower($comunidad->comunicacion_preferida) == "email" &&
                    !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $comunidad->email_envio)
                ) {
                    $incidencias[] = "La comunidad destinataria " . $comunidad->comunidad . " carece de email para el env&iacute;o de nuestras solicitudes";
                }
            }
        }
        if (count($incidencias) > 0) {
            $titulo = "Comunidades sin email de env&iacute;o de solicitud";
            return view('nuestrasSolicitudes.comprobacion',
                compact('titulo',
                    'incidencias',
                    'nuestrasComunidades',
                    'comunidadesDestinatarias',
                    'cursos',
                    'conSusRespuestas'
                ));
        }
        return $this->enviarCursillos($request);
    }

    public function enviarCursillos(Request $request)
    {
        $ConSusRespuestas = filter_var($request->get("incluirEnSusRespuestas"), FILTER_VALIDATE_BOOLEAN);
        $cursillosIds = $request->get("cursos");
        $comunidadesDestinatariasIds = $request->get('comunidadesDestinatarias');
        $comunidadesDestinatarias = Comunidades::obtenerComunidadesPDF($comunidadesDestinatariasIds);
        $cursillos = Cursillos::obtenerComunidadesCursillosPDF($cursillosIds);

        //Verificación
        if (count($comunidadesDestinatarias) == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasSolicitudes')->
            with('mensaje', 'No se puede realizar la operaci&oacute;n, comprueba que exista destinatarios  y/o cursos');
        }
        //Datos del remitente por medio de su curso
        $remitente = $cursillos[0];

        //Si no tuviera correo de envío le creamos un correo ficticio
        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $remitente->email_envio)) {
            $remitente->email_solicitud = $remitente->comunidad . '@noTengoCorreo.com';
        }

        //Configuración del listado html
        $listadoPosicionInicial = 43.5; //primera linea
        $listadoTotal = 9;  // nº lineas cursillo max primera pagina
        $listadoTotalRestoPagina = 40; // nº lineas cursillo resto de las paginas
        $separacionLinea = 1.5;

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];
        $logEnvios[] = ["Comienzo: " . date("d/m/Y H:i:s", strtotime('now')), "", "time green icon-size-large"];
        //PDF en múltiples páginas
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
        $comunidadesDestinatariasIncluidas = [];

        $destinatariosConCarta = 0;
        $destinatariosConCartaCreada = 0;
        $destinatariosConEmail = 0;
        $destinatariosConEmailEnviado = 0;

        foreach ($cursillos as $idx => $cursillo) {
            $cursos[] = sprintf("Nº %'06s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
            //if (!$cursillo->esSolicitud || ($cursillo->esSolicitud && $request->get('generarSusRespuestas'))) {
            $cursosActualizados[] = sprintf("Cuso Nº %'06s de la comunidad %10s cambiado al estado de es solicitud.", $cursillo->num_cursillo, $cursillo->comunidad);
            $contadorCursosActualizados += 1;
            $cursosActualizadosIds[] = $cursillo->curso_id;
            //}
        }
        //Ruta Linux
        $separatorPath = "/";
        $path = "solicitudesCursillos";
        //Ampliamos el tiempo de ejecución del servidor a 60 minutos.
        ini_set("max_execution_time", config('opciones.envios.timeout'));
        foreach ($comunidadesDestinatarias as $idx => $comunidadDestinataria) {
            //Sólo queremos actualizar la base de datos
            if ($ConSusRespuestas) {
                if (strtolower($comunidadDestinataria->comunicacion_preferida) == "email" &&
                    preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $comunidadDestinataria->email_envio)
                ) {
                    $comunidadesDestinatariasIncluidas[] = [$comunidadDestinataria->id, $comunidadDestinataria->comunidad];
                }
            } else {
                //intentanmos modificar el tiempo de ejecución del script.
                set_time_limit(config('opciones.envios.seMaxtTimeAt'));
                $archivo = $path . $separatorPath . "NS-" . date("d_m_Y", strtotime('now')) . '-' . $comunidadDestinataria->pais . '-' . $comunidadDestinataria->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';

                // modalidadComunicacion si es distinto de carta , si su comunicación preferida es email y si tiene correo destinatario para el envío
                if (strtolower($comunidadDestinataria->comunicacion_preferida) == "email" && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $comunidadDestinataria->email_solicitud)) {
                    //Nombre del archivo a adjuntar
                    $archivoMail = "templatePDF" . $separatorPath . 'NS-' . $remitente->comunidad . '.pdf';
                    //Conversión a UTF
                    $nombreArchivoAdjuntoEmail = mb_convert_encoding($archivoMail, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
                    $nombreArchivoAdjuntoEmail = str_replace(" ", "", $nombreArchivoAdjuntoEmail);
                    try {
                        $pdf = \App::make('dompdf.wrapper');
                        $view = \View::make('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                            compact('cursos', 'remitente', 'comunidadDestinataria', 'fecha_emision'
                                , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                            ))->render();
                        $pdf->loadHTML($multiplesPdfBegin . $view . $multiplesPdfEnd);
                        $pdf->output();
                        $pdf->save($nombreArchivoAdjuntoEmail);
                        $logEnvios[] = ["Creado documento adjunto para la comunidad " . $comunidadDestinataria->comunidad, "", "floppy-saved green icon-size-large"];
                    } catch (\Exception $ex) {
                        $logEnvios[] = ["Error al crear el documento adjunto para la comunidad " . $comunidadDestinataria->comunidad, "", "floppy-remove red icon-size-large"];
                    }
                    try {
                        if (config("opciones.emailTestSender.active")) {
                            $comunidadDestinataria->email_solicitud = config("opciones.emailTestSender.email");
                            $comunidadDestinataria->email_envio = config("opciones.emailTestSender.email");
                        }

                        $destinatariosConEmail += 1;
                        $envio = Mail::send('nuestrasSolicitudes.pdf.cartaSolicitudA1',
                            compact('cursos', 'remitente', 'comunidadDestinataria', 'fecha_emision'),
                            function ($message) use ($remitente, $comunidadDestinataria, $nombreArchivoAdjuntoEmail) {
                                $message->from($remitente->email_solicitud);
                                $message->to($comunidadDestinataria->email_solicitud)->subject("Nuestra Solicitud");
                                $message->attach($nombreArchivoAdjuntoEmail);
                            });
                        if ($envio > 0) {
                            $destinatariosConEmailEnviado += 1;
                            $comunidadesDestinatariasIncluidas[] = [$comunidadDestinataria->id, $comunidadDestinataria->comunidad];
                        }
                        unlink($nombreArchivoAdjuntoEmail);


                    } catch (\Exception $ex) {
                        if ($ex->getCode() == 535) {
                            $logEnvios[] = ["Petición rechazada por " . env("HOST") . " comunidad afectada: " . $comunidadDestinataria->comunidad, "", "envelope red icon-size-large"];
                        } elseif (config('opciones.verErrorMailServer')) {
                            $logEnvios[] = [$ex->getMessage(), "", "envelope red icon-size-large"];
                        }
                        $envio = 0;
                    }
                    $logEnvios[] = $envio > 0 ? ["Enviada solicitud a la comunidad " . $comunidadDestinataria->comunidad . " al email " . $comunidadDestinataria->email_solicitud, "", "envelope green icon-size-large"] :
                        ["No se pudo enviar la solicitud a la comunidad " . $comunidadDestinataria->comunidad . " al email " . $comunidadDestinataria->email_solicitud, "", "envelope red icon-size-large"];
                } elseif
                (strtolower($comunidadDestinataria->comunicacion_preferida == "email")) {
                    $logEnvios[] = ["La comunidad destinataria " . $comunidadDestinataria->comunidad . " no tiene un formato de correo v&aacute;lido", "", "envelope red icon-size-large"];
                    $destinatariosConEmail += 1;
                } elseif
                (strtolower($comunidadDestinataria->comunicacion_preferida) == "carta") {
                    try {
                        $destinatariosConCarta += 1;
                        $view = \View::make('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3',
                            compact('cursos', 'remitente', 'comunidadDestinataria', 'fecha_emision'
                                , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                            ))->render();
                        $multiplesPdfContain .= $view;
                        $logEnvios[] = ["Creada carta de solicitud para la comunidad " . $comunidadDestinataria->comunidad, "", "align-justify green icon-size-large"];
                        $destinatariosConCartaCreada += 1;
                        $comunidadesDestinatariasIncluidas[] = [$comunidadDestinataria->comunidad_id, $comunidadDestinataria->comunidad];
                    } catch (\Exception $ex) {
                        $logEnvios[] = ["No se ha podido crear la carta de solicitud para la comunidad " . $comunidadDestinataria->comunidad, "", "align-justify red icon-size-large"];
                    }
                }
            }//Fin comunidadesDestinatarias
        }
        if ($destinatariosConCartaCreada > 0) {
            $pathTotalComunidadesCarta = $path . $separatorPath . "NS-" . date("d_m_Y", strtotime('now')) . '-' . "TotalComunidadesCarta.pdf";
            $multiplesPdf->loadHTML($multiplesPdfBegin . $multiplesPdfContain . $multiplesPdfEnd);
            $multiplesPdf->output();
            $multiplesPdf->save($pathTotalComunidadesCarta);
            $logEnvios[] = ["Cartas creadas de nuestras solicitudes.", $pathTotalComunidadesCarta, "list-alt green icon-size-large", "Cartas"];
        }

        if (count($logEnvios) == 0) {
            $logEnvios[] = ["No hay operaciones que realizar.", "", "remove-sign red icon-size-large"];
        } else {
            $logEnvios[] = ["[" . $destinatariosConEmailEnviado . "/" . $destinatariosConEmail . "]" . " correos enviados.", "", "info-sign info icon-size-large"];
            $logEnvios[] = ["[" . $destinatariosConCartaCreada . "/" . $destinatariosConCarta . "]" . " cartas creadas.", "", "info-sign info icon-size-large"];
            $logEnvios[] = ["Solicitudes procesadas de " . count($cursillos) . " curso" . (count($cursillos) > 1 ? "s" : "") . " de la comunidad " . $remitente->comunidad, "", "info-sign info icon-size-large"];
        }
//Cambiamos de estado las solicitudes que no están como esSolicitud
        if (count($comunidadesDestinatariasIncluidas) > 0 && count($cursosActualizadosIds) > 0) {
            if (Cursillos::setCursillosEsSolicitud($cursosActualizadosIds) == $contadorCursosActualizados && $contadorCursosActualizados > 0) {
                $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contadorCursosActualizados > 1 ? "s" : "") . " de la comunidad " . $remitente->comunidad . " ha"
                    . ($contadorCursosActualizados > 1 ? "n" : "") . " sido actualizado" . ($contadorCursosActualizados > 1 ? "s" : "") . " a solicitud realizada.", "", "info-sign info icon-size-large"];
            } elseif ($contadorCursosActualizados > 0) {
                $logEnvios[] = [count($cursosActualizados) . " Cursos de la comunidad " . $remitente->comunidad . " no se ha" . ($contadorCursosActualizados > 1 ? "n" : "") .
                    " podido actualizar como Solicitud.", "", "exclamation-sign red icon-size-large"];
            }
        }

//Actualizamos las tablas de forma automática y añadimos los logs
        $logSolicitudesEnviadas = SolicitudesEnviadas::crearComunidadesCursillos($comunidadesDestinatariasIncluidas, $cursosActualizadosIds);
//Obtenemos el último registro del log generado.
        if (count($logSolicitudesEnviadas) > 0) {
            $logEnvios[] = $logSolicitudesEnviadas[count($logSolicitudesEnviadas) - 1];
        }

//Path dónde se guarda el log de nuestras solicitudes
        $logPath = 'logs/NS/NS_log_' . date('d_m_Y_H_i_s');

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
        file_put_contents($logPath, $logArchivo, true);
//Ponemos un download para el log en la vista
        $logEnvios[] = ["Log de nuestras solicitudes.", $logPath, "", "Log"];
//Finalizamos las respuestas
        $logEnvios[] = ["Finalización: " . date("d/m/Y H:i:s", strtotime('now')), "", "time green icon-size-large"];
        $titulo = "Operaciones Realizadas";
        return view('nuestrasSolicitudes.listadoLog',
            compact('titulo', 'logEnvios'));

    }
}
