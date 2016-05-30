<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Entities\TiposComunicacionesPreferidas;

class NuestrasRespuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Responder";
        //Comprobamos si el server permite modificar el tiempo de ejecución del script.
        $comprobarModoSeguro = set_time_limit(config('opciones.envios.seMaxtTimeAt'));
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false, '', false);
        $restoComunidades = Comunidades::getComunidadesList(false, $comprobarModoSeguro, "Enviar las respuestas pendientes", true);
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList("Email + Carta");
        $modalidad = $request->get("modalidad");
        $anyos = Array();
        $cursillos = Array();
        return view('nuestrasRespuestas.index',
            compact(
                'nuestrasComunidades',
                'restoComunidades',
                'cursillos',
                'anyos',
                'modalidad',
                'tipos_comunicaciones_preferidas',
                'titulo'));
    }

    public function comprobarRespuestas(Request $request)
    {
        $incluirRespuestasAnteriores = filter_var($request->get('incluirRespuestasAnteriores'), FILTER_VALIDATE_BOOLEAN);
        $tipoComunicacion = $request->get('modalidad');
        $destinatarios = Comunidades::getComunidadPDFRespuestas($request->get('restoComunidades'), false, true, $incluirRespuestasAnteriores, $tipoComunicacion);

        if ($tipoComunicacion != 1) {
            $incidencias = array();
            foreach ($destinatarios as $idx => $destinatario) {
                if (strtolower($destinatario->comunicacion_preferida) == strtolower(config("opciones.tipo.email")) && (strlen($destinatario->email_envio) == 0)) {
                    $incidencias[] = "La comunidad destinataria " . $destinatario->comunidad . " carece de email para el envío de nuestras respuestas";
                }
            }
            if (count($incidencias) > 0) {
                $tipos_comunicaciones_preferidas = $tipoComunicacion;
                $nuestrasComunidades = $request->get('nuestrasComunidades');
                $anyos = $request->get('anyo');
                $incluirRespuestasAnteriores = $incluirRespuestasAnteriores;
                $restoComunidades = $request->get('restoComunidades');
                $titulo = "Comunidades sin email de envío de respuestas";
                return view('nuestrasRespuestas.comprobacion',
                    compact('titulo',
                        'incidencias',
                        'tipos_comunicaciones_preferidas',
                        'nuestrasComunidades',
                        'anyos',
                        'incluirRespuestasAnteriores',
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
        $incluirRespuestasAnteriores = filter_var($request->get('incluirRespuestasAnteriores'), FILTER_VALIDATE_BOOLEAN);
        $destinatarios = Comunidades::getComunidadPDFRespuestas($request->get('restoComunidades'), false, true, $incluirRespuestasAnteriores, $tipoEnvio);
        $cursillos = Cursillos::getCursillosPDFRespuesta($request->get('restoComunidades'), $request->get('anyo'), $request->get('incluirRespuestasAnteriores'), false);

        //Verificación
        $numeroDestinatarios = count($destinatarios);
        if (count($remitente) == 0 || $numeroDestinatarios == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasRespuestas')->
            with('mensaje', 'No se puede realizar la operación, debe de existir remitente y/o destinatario/s  y/o curso/s');
        }
        //Configuración del listado html
        $listadoPosicionInicial = 40.5;
        $listadoTotal = 11;
        $listadoTotalRestoPagina = 40;
        $separacionLinea = 1.5;

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        //Array contenedor de logs.
        $logEnvios = [];
        //Colección de cursos que van a ser actualizados y sus correspondiente mensajes.
        $comunidadesDestinatarias = [];
        $totalCursosActualizadosIds = [];
        $totalCursosActualizados = [];
        $totalContadorCursosActualizados = 0;
        $totalContadorCursos = 0;
        //PDF en múltiples páginas
        $destinatariosConCarta = 0;
        $destinatariosConEmail = 0;
        $multiplesPdf = \App::make('dompdf.wrapper');
        $multiplesPdfBegin = '<html lang="es">';
        $multiplesPdfContain = "";
        $multiplesPdfEnd = '</html>';

        //Ampliamos el tiempo de ejecución del servidor a 60 minutos.
        ini_set("max_execution_time", config('opciones.envios.timeout'));

        foreach ($destinatarios as $idx => $destinatario) {
            //Ruta para linux
            $separatorPath = "/";
            $path = "respuestasCursillos";
            $archivo = $path . $separatorPath . "NR-" . date("d_m_Y", strtotime('now')) . '-' . $destinatario->pais . '-' . $destinatario->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            //Conversión a UTF
            $nombreArchivo = mb_convert_encoding($archivo, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
            $cursos = [];
            $cursosActualizados = [];
            $cursosActualizadosIds = [];

            $esCarta = true;
            foreach ($cursillos as $idx => $cursillo) {

                if ($cursillo->comunidad_id == $destinatario->id) {
                    if (config("opciones.accion.cartaCumplimentadaIndividualNuestrasRespuestas")) {
                        $curso[] = ['num' => $cursillo->num_cursillo,
                            'dia' => date('d', strtotime($cursillo->fecha_inicio)),
                            'mes' => $meses[date('n', strtotime($cursillo->fecha_inicio)) - 1],
                            'anyo' => date('Y', strtotime($cursillo->fecha_inicio))];
                    }
                    $cursos[] = sprintf("Nº %'06s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                    if (!$cursillo->esRespuesta) {
                        $cursosActualizados[] = sprintf("Cuso Nº %'06s de la comunidad %10s cambiado a estado de respuesta realizada.", $cursillo->num_cursillo, $destinatario->comunidad);
                        $cursosActualizadosIds[] = $cursillo->id;
                        $totalContadorCursos += 1;
                    }
                }
            }
            //Reseteamos el tiempo de ejecución del script definiendo un nuevo tamaño de espera.
            set_time_limit(config('opciones.envios.seMaxtTimeAt'));
            // $tipoEnvio si es distinto de carta , si su comunicación preferida es email y si tiene correo destinatario para el envío
            if ($tipoEnvio != 1 && (strcasecmp($destinatario->comunicacion_preferida, config("opciones.tipo.email")) == 0) && (strlen($destinatario->email_envio) > 0)) {
                $archivoEmail = 'templatePDF' . $separatorPath . 'NR-' . $remitente->comunidad . '.pdf';
                //Conversión a UTF
                $nombreArchivoAdjuntoEmail = mb_convert_encoding($archivoEmail, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
                $nombreArchivoAdjuntoEmail = str_replace(" ", "_", $nombreArchivoAdjuntoEmail);

                try {
                    $pdf = \App::make('dompdf.wrapper');
                    if (config("opciones.accion.cartaCumplimentadaIndividualNuestrasRespuestas")) {
                        $multiplesPdfContain = "";
                        foreach ($curso as $cur) {
                            $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3PorCurso',
                                compact('cur', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                                    , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                                ))->render();
                            $multiplesPdfContain .= $view;
                        }
                        $view = $multiplesPdfContain;
                    } else {
                        $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3',
                            compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                                , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                            ))->render();
                    }
                    $pdf->loadHTML($multiplesPdfBegin . $view . $multiplesPdfEnd);
                    $pdf->output();
                    $pdf->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = ["Creado documento adjunto para el email de respuesta a la comunidad " . $destinatario->comunidad, "", "floppy-saved green icon-size-large"];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el documento adjunto para email de " . $destinatario->comunidad, "", "floppy-remove red icon-size-large"];
                }
                $esCarta = false;
                //Obtenemos el número de cursillos a procesar
                $contador = count($cursosActualizados);

                try {
                    if (config("opciones.emailTestSender.active")) {
                        $destinatario->email_solicitud = config("opciones.emailTestSender.email");
                        $destinatario->email_envio = config("opciones.emailTestSender.email");
                    }
                    $envio = Mail::send("nuestrasRespuestas.pdf.cartaRespuestaB1",
                        ['cursos' => $cursos, 'remitente' => $remitente, 'destinatario' => $destinatario, 'fecha_emision' => $fecha_emision, 'esCarta' => $esCarta]
                        , function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                            $message->from($remitente->email_envio, $remitente->comunidad);
                            $message->to($destinatario->email_envio)->subject("Nuestra Respuesta");
                            $message->attach($nombreArchivoAdjuntoEmail);
                        });

                    $destinatariosConEmail += 1;
                    $comunidadesDestinatarias[] = [$destinatario->id, $destinatario->comunidad];
                    $totalContadorCursosActualizados += $contador;
                    foreach ($cursosActualizados as $actualizados) {
                        $totalCursosActualizados[] .= $actualizados;
                    }
                    foreach ($cursosActualizadosIds as $id) {
                        $totalCursosActualizadosIds[] .= $id;
                    }

                    if ($contador > 0) {
                        $logEnvios[] = [$contador . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $destinatario->comunidad . " está"
                            . ($contador > 1 ? "n" : "") . " preparado" . ($contador > 1 ? "s" : "") . " para cambiar al estado de respuesta realizada.", "", "dashboard warning icon-size-normal"];
                    }

                    unlink($nombreArchivoAdjuntoEmail);

                } catch (\Exception $ex) {
                    if (count($cursosActualizados) > 0) {
                        $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $destinatario->comunidad . " excluido"
                            . ($contador > 1 ? "s" : "") . " del cambio de estado a respuesta" . ($contador > 1 ? "s" : "") . " realizada" . ($contador > 1 ? "s." : "."), "", "dashboard red icon-size-normal"];
                    }
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviada respuesta a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_envio, "", "envelope green icon-size-large"] :
                    ["No se pudo enviar la respuesta a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_envio, "", "envelope red icon-size-large"];
            } elseif ($tipoEnvio != 1 && (strcasecmp($destinatario->comunicacion_preferida, config("opciones.tipo.email")) == 0) && (strlen($destinatario->email_envio) == 0)) {
                $logEnvios[] = ["La comunidad destinataria " . $destinatario->comunidad . " no dispone de email de respuesta", "", "envelope red icon-size-large"];
            } elseif ($tipoEnvio != 2 && (strcasecmp($destinatario->comunicacion_preferida, config("opciones.tipo.email")) != 0)) {
                $contador = count($cursosActualizados);
                try {
                    $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                            , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                        ))->render();
                    $multiplesPdfContain .= $view;
                    $logEnvios[] = ["Creada carta de respuesta para la comunidad " . $destinatario->comunidad, "", "align-justify green icon-size-large"];
                    $destinatariosConCarta += 1;
                    $comunidadesDestinatarias[] = [$destinatario->id, $destinatario->comunidad];
                    $totalContadorCursosActualizados += $contador;
                    foreach ($cursosActualizados as $actualizados) {
                        $totalCursosActualizados[] .= $actualizados;
                    }
                    foreach ($cursosActualizadosIds as $id) {
                        $totalCursosActualizadosIds[] .= $id;
                    }
                    if ($contador > 0) {
                        $logEnvios[] = [$contador . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $destinatario->comunidad . " está"
                            . ($contador > 1 ? "n" : "") . " preparado" . ($contador > 1 ? "s" : "") . " para cambiar al estado de respuesta realizada.", "", "dashboard warning icon-size-normal"];
                    }
                } catch (\Exception $e) {
                    $logEnvios[] = ["No se ha podido crear la carta de respuesta para la comunidad " . $destinatario->comunidad, "", "align-justify red icon-size-large"];
                    $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $destinatario->comunidad . " excluido"
                        . ($contador > 1 ? "s" : "") . " del cambio de estado a respuesta" . ($contador > 1 ? "s" : "") . " realizada" . ($contador > 1 ? "s." : "."), "", "dashboard red icon-size-normal"];
                }
            }
        }
        if ($destinatariosConCarta > 0) {
            $pathTotalComunidadesCarta = $path . $separatorPath . "NR-" . date("d_m_Y", strtotime('now')) . '-' . "TotalComunidadesCarta.pdf";
            $multiplesPdf->loadHTML($multiplesPdfBegin . $multiplesPdfContain . $multiplesPdfEnd);
            $multiplesPdf->output();
            $multiplesPdf->save($pathTotalComunidadesCarta);
            $logEnvios[] = ["Creada cartas de respuesta.", $pathTotalComunidadesCarta, "list-alt green icon-size-large"];
        }
        if (count($logEnvios) == 0) {
            $logEnvios[] = ["No hay operaciones que realizar.", "", "remove-sign red icon-size-large"];
        } else {
            if ($destinatariosConEmail > 0) {
                $logEnvios[] = [$destinatariosConEmail . ($destinatariosConEmail > 1 ? " emails enviados." : " email enviado"), "", "info-sign info icon-size-large"];
            }
            if ($destinatariosConCarta > 0) {
                $logEnvios[] = [$destinatariosConCarta . ($destinatariosConCarta > 1 ? " cartas creadas." : " carta creada."), "", "info-sign info icon-size-large"];
            }

            //Cambiamos de estado las respuestas que no están como esRespuesta
            if ($totalContadorCursosActualizados > 0) {
                if (Cursillos::setCursillosEsRespuesta($totalCursosActualizadosIds) == $totalContadorCursosActualizados && $totalContadorCursosActualizados > 0) {
                    $logEnvios[] = ["[" . $totalContadorCursosActualizados . "/" . $totalContadorCursos . "] Curso" . ($totalContadorCursosActualizados > 1 ? "s" : "") . " ha"
                        . ($totalContadorCursosActualizados > 1 ? "n" : "") . " cambiado al estado de respuesta realizada.", "", "info-sign info icon-size-large"];
                } elseif ($totalContadorCursosActualizados > 0) {
                    $logEnvios[] = [$totalContadorCursosActualizados . " Curso" . ($totalContadorCursosActualizados > 1 ? "s" : "") .
                        " no se ha" . ($totalContadorCursosActualizados > 1 ? "n" : "") .
                        " podido actualizar como Respuesta.", "", "exclamation-sign info icon-size-large"];
                }
            }
            //Actualizamos las tablas de forma automática y añadimos los logs
            $logSolicitudesRecibidas = SolicitudesRecibidas::crearComunidadesCursillos($comunidadesDestinatarias, $totalCursosActualizadosIds);
            //Obtenemos el último registro del log generado.

            if (count($logSolicitudesRecibidas) > 0) {
                $logEnvios[] = $logSolicitudesRecibidas[count($logSolicitudesRecibidas) - 1];

            }
            //Creamos la cabecera del Log
            $logArchivo = array();
            $logArchivo[] = 'Fecha->' . date('d/m/Y H:i:s') . "\n";
            $logArchivo[] = 'Usuario->' . $request->user()->name . "\n";
            $logArchivo[] = 'Email->' . $request->user()->email . "\n";
            $logArchivo[] = 'Ip->' . $request->server('REMOTE_ADDR') . "\n";
            $logArchivo[] = '******************************************' . "\n";

            foreach ($logEnvios as $log) {
                $logArchivo[] = $log[0] . "\n";
            }

            if ($totalContadorCursosActualizados > 0) {
                foreach ($totalCursosActualizados as $log) {
                    $logArchivo[] = $log . "\n";
                }
            }
            //Guardamos a archivo
            file_put_contents('logs/NR/NR_log_' . date('d_m_Y_H_i_s'), $logArchivo, true);
        }
        $titulo = "Operaciones Realizadas";
        return view('nuestrasRespuestas.listadoLog',
            compact('titulo', 'logEnvios'));
    }
}
