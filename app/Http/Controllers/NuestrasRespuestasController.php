<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\SolicitudesEnviadasCursillos;
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
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false, '', false);
        $restoComunidades = Array();
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList("Email + Carta", true);
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
        $incidencias = array();
        $cursosIds = $request->get('cursos');
        $nuestrasComunidades = $request->get('nuestrasComunidades');
        $cursos = Cursillos::obtenerComunidadesCursillosPDF($cursosIds)->groupBy('comunidad');
        if (count($cursos) > 0) {
            foreach ($cursos as $idx => $curso) {
                $comunidad = $curso[0];
                if (strtolower($comunidad->comunicacion_preferida) == strtolower(config("opciones.tipo.email")) &&
                    !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $comunidad->email_envio)
                ) {
                    $incidencias[] = "La comunidad destinataria " . $comunidad->comunidad . " carece de email para el env&iacute;o de nuestras respuestas";
                }
            }
        }
        if (count($incidencias) > 0) {
            $titulo = "Comunidades sin email de env&iacute;o de respuestas";
            return view('nuestrasRespuestas.comprobacion',
                compact('titulo',
                    'incidencias',
                    'cursosIds',
                    'nuestrasComunidades'
                ));
        }
        return $this->enviarCursillos($request);
    }

    function enviarCursillos(Request $request)
    {
        $cursillosIds = $request->get("cursos");
        //Obtenemos la comunidad del remitente
        $remitente = Comunidades::getComunidadPDF($request->get('nuestrasComunidades'));
        //Validamos su correo

        if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $remitente->email_envio)) {
            $remitente->email_envio = $remitente->comunidad . '@noTengoCorreo.com';
        }

        //Nos traemos los cursillos
        $cursillos = Cursillos::obtenerComunidadesCursillosPDF($cursillosIds);
        //Obtenemos los nombres de las comnunidades con sus correspondientes cursos
        $comunidades = $cursillos->groupBy("comunidad");

        if (count($cursillos) == 0) {
            return redirect()->
            route('nuestrasRespuestas')->
            with('mensaje', 'No se puede realizar la operaci&oacute;n, debe de existir alg&uacute; curso seleccionado.');
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
        $logEnvios[] = ["Comienzo: " . date("d/m/Y H:i:s", strtotime('now')), "", "time green icon-size-large"];

        //Colección de cursos que van a ser actualizados y sus correspondiente mensajes.
        $comunidadesDestinatarias = [];
        $totalCursosActualizadosIds = [];
        $totalCursosActualizados = [];
        $totalContadorCursosActualizados = 0;
        $totalContadorCursos = 0;
        $cursos = [];
        //Cartas
        $comunidadesConCarta = 0;
        $comunidadesConCartaCreada = 0;
        //Email
        $comunidadesConEmail = 0;
        $comunidadesConEmailEnviado = 0;
        //PDF en múltiples páginas
        $multiplesPdf = \App::make('dompdf.wrapper');
        $multiplesPdfBegin = '<html lang="es">';

        $multiplesPdfCarta = "";
        $multiplesPdfEnd = '</html>';


        //Ruta para linux
        $separatorPath = "/";
        $path = "respuestasCursillos";
        //Ampliamos el tiempo de ejecución del servidor a 60 minutos.
        ini_set("max_execution_time", config('opciones.envios.timeout'));
        foreach ($comunidades as $idx => $cursosPorComunidad) {
            //Reseteamos el tiempo de ejecución del script definiendo un nuevo tamaño de espera.
            set_time_limit(config('opciones.envios.seMaxtTimeAt'));
            $comunidad = $idx;
            $archivo = $path . $separatorPath . "NR-" . date("d_m_Y_H_i_s", strtotime('now')) . '-' . $cursosPorComunidad[0]->pais . '-' . $cursosPorComunidad[0]->comunidad . '-Cursos.pdf';

            $cursosActualizados = [];
            $cursoActual = $cursosPorComunidad[0];
            $comunidadDestinataria = $cursoActual;

            if (strtolower($cursoActual->comunicacion_preferida) == "email" && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $cursoActual->email_envio)) {
                $archivoEmail = 'templatePDF' . $separatorPath . 'NR-' . $comunidad . '.pdf';
                //Conversión a UTF
                $nombreArchivoAdjuntoEmail = mb_convert_encoding($archivoEmail, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
                $nombreArchivoAdjuntoEmail = str_replace(" ", "_", $nombreArchivoAdjuntoEmail);

                try {
                    $pdf = \App::make('dompdf.wrapper');
                    if (config("opciones.accion.cartaCumplimentadaIndividualNuestrasRespuestas")) {
                        $multiplesPdfEmail = "";
                        foreach ($cursosPorComunidad as $cursoComunidad) {
                            $curso = ['num' => $cursoComunidad->num_cursillo,
                                'dia' => date('d', strtotime($cursoComunidad->fecha_inicio)),
                                'mes' => $meses[date('n', strtotime($cursoComunidad->fecha_inicio)) - 1],
                                'anyo' => date('Y', strtotime($cursoComunidad->fecha_inicio))];

                            $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3_CumplimentadaPorCurso',
                                compact('curso', 'remitente', 'comunidadDestinataria', 'fecha_emision'
                                    , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                                ))->render();
                            $multiplesPdfEmail .= $view;
                        }
                    } else {
                        $multiplesPdfEmail = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3',
                            compact('cursosPorComunidad', 'remitente', 'comunidadDestinataria', 'fecha_emision'
                                , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                            ))->render();
                    }
                    $pdf->loadHTML($multiplesPdfBegin . $multiplesPdfEmail . $multiplesPdfEnd);
                    $pdf->output();
                    $pdf->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = ["Creado documento adjunto para el email de respuesta a la comunidad " . $comunidad, "", "floppy-saved green icon-size-large"];
                } catch (\Exception $ex) {
                    $logEnvios[] = ["Error al crear el documento adjunto para email de " . $comunidad, "", "floppy-remove red icon-size-large"];
                }

                //Obtenemos el número de cursillos a procesar

                try {
                    if (config("opciones.emailTestSender.active")) {
                        $cursoActual->email_solicitud = config("opciones.emailTestSender.email");
                        $cursoActual->email_envio = config("opciones.emailTestSender.email");
                    }
                    $contador = 0;
                    $comunidadesConEmail += 1;

                    $envio = Mail::send("nuestrasRespuestas.pdf.cartaRespuestaB1",
                        ['cursos' => $cursosPorComunidad, 'remitente' => $remitente, 'destinatario' => $cursoActual, 'fecha_emision' => $fecha_emision,]
                        , function ($message) use ($remitente, $cursoActual, $nombreArchivoAdjuntoEmail, $fecha_emision) {
                            $message->from($remitente->email_envio);
                            $message->to($cursoActual->email_envio)->subject("Nuestra Respuesta");
                            $message->attach($nombreArchivoAdjuntoEmail);
                        });

                    if ($envio > 0) {
                        $contador = count($cursosPorComunidad);
                        $comunidadesConEmailEnviado += 1;
                        $comunidadesDestinatarias[] = [$cursoActual->comunidad_id, $comunidad];
                        $totalContadorCursosActualizados += $contador;
                        foreach ($cursosPorComunidad as $idx => $cursoComunidad) {
                            if (!$cursoComunidad->esRespuesta) {
                                $totalCursosActualizados[] .= sprintf("Cuso Nº %'06s de la comunidad %10s cambiado a estado de respuesta realizada.", $cursoComunidad->num_cursillo, $comunidad);
                                $totalCursosActualizadosIds[] = $cursoComunidad->curso_id;
                            }
                        }

                        if ($contador > 0) {
                            $logEnvios[] = [$contador . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $comunidad . " est&aacute;"
                                . ($contador > 1 ? "n" : "") . " preparado" . ($contador > 1 ? "s" : "") . " para cambiar al estado de respuesta realizada.", "", "dashboard warning icon-size-normal"];
                        }
                    }
                    unlink($nombreArchivoAdjuntoEmail);

                } catch (\Exception $ex) {
                    if ($ex->getCode() == 535) {
                        $logEnvios[] = ["Petición rechazada por " . env("HOST") . " comunidad afectada: " . $comunidad, "", "envelope red icon-size-large"];
                    } elseif (count($cursosActualizados) > 0) {
                        $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $comunidad . " excluido"
                            . ($contador > 1 ? "s" : "") . " del cambio de estado a respuesta" . ($contador > 1 ? "s" : "") . " realizada" . ($contador > 1 ? "s." : "."), "", "dashboard red icon-size-normal"];
                    } elseif (config('opciones.verErrorMailServer')) {
                        $logEnvios[] = ['error=>' . $ex->getMessage(), "", "envelope red icon-size-large"];
                    }

                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviada respuesta a la comunidad " . $comunidad . " al email " . $cursoActual->email_envio, "", "envelope green icon-size-large"] :
                    ["No se pudo enviar la respuesta a la comunidad " . $comunidad . " con email " . $cursoActual->email_envio, "", "envelope red icon-size-large"];
            } elseif (strtolower($cursoActual->comunicacion_preferida) == "email") {
                $logEnvios[] = ["La comunidad destinataria " . $comunidad . " no dispone de un formato correcto de email", "", "envelope red icon-size-large"];
                $comunidadesConEmail += 1;
            } elseif (strtolower($cursoActual->comunicacion_preferida) == "carta") {
                $contador = count($cursosActualizados);
                $comunidadesConCarta += 1;
                try {
                    $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3',
                        compact('cursosPorComunidad', 'remitente', 'comunidadDestinataria', 'fecha_emision'
                            , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                        ))->render();
                    $multiplesPdfCarta .= $view;
                    $logEnvios[] = ["Creada carta de respuesta para la comunidad " . $comunidad, "", "align-justify green icon-size-large"];
                    $comunidadesConCartaCreada += 1;
                    $comunidadesDestinatarias[] = [$cursoActual->comunidad_id, $comunidad];
                    $totalContadorCursosActualizados += $contador;
                    foreach ($cursosPorComunidad as $idx => $cursoComunidad) {
                        if (!$cursoComunidad->esRespuesta) {
                            $totalCursosActualizados[] .= sprintf("Cuso Nº %'06s de la comunidad %10s cambiado a estado de respuesta realizada.", $cursoComunidad->num_cursillo, $comunidad);
                            $totalCursosActualizadosIds[] = $cursoComunidad->curso_id;
                        }
                    }
                    if ($contador > 0) {
                        $logEnvios[] = [$contador . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $comunidad . " est&aacute;"
                            . ($contador > 1 ? "n" : "") . " preparado" . ($contador > 1 ? "s" : "") . " para cambiar al estado de respuesta realizada.", "", "dashboard warning icon-size-normal"];
                    }
                } catch (\Exception $ex) {
                    $logEnvios[] = ["No se ha podido crear la carta de respuesta para la comunidad " . $comunidad, "", "align-justify red icon-size-large"];
                    $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contador > 1 ? "s" : "") . " de la comunidad " . $comunidad . " excluido"
                        . ($contador > 1 ? "s" : "") . " del cambio de estado a respuesta" . ($contador > 1 ? "s" : "") . " realizada" . ($contador > 1 ? "s." : "."), "", "dashboard red icon-size-normal"];
                }
            }
        }
        //Fin del bucle de comunidades

        if ($comunidadesConCartaCreada > 0) {
            $pathTotalComunidadesCarta = $path . $separatorPath . "NR-" . date("d_m_Y", strtotime('now')) . '-' . "TotalComunidadesCarta.pdf";
            $multiplesPdf->loadHTML($multiplesPdfBegin . $multiplesPdfCarta . $multiplesPdfEnd);
            $multiplesPdf->output();
            $multiplesPdf->save($pathTotalComunidadesCarta);
            $logEnvios[] = ["Cartas creadas de nuestras respuestas.", $pathTotalComunidadesCarta, "list-alt green icon-size-large"];
        }
        if (count($logEnvios) == 0) {
            $logEnvios[] = ["No hay operaciones que realizar.", "", "remove-sign red icon-size-large"];
        } else {
            $logEnvios[] = ["[" . $comunidadesConEmailEnviado . "/" . $comunidadesConEmail . "]" . " correos enviados.", "", "info-sign info icon-size-large"];
            $logEnvios[] = ["[" . $comunidadesConCartaCreada . "/" . $comunidadesConCarta . "]" . " cartas creadas.", "", "info-sign info icon-size-large"];

            //Cambiamos de estado las respuestas que no están como esRespuesta
            if ($totalContadorCursosActualizados > 0) {
                if (Cursillos::setCursillosEsRespuesta($totalCursosActualizadosIds) == $totalContadorCursosActualizados && $totalContadorCursosActualizados > 0) {
                    $logEnvios[] = ["[" . $totalContadorCursosActualizados . "/" . $totalContadorCursos . "] Curso" . ($totalContadorCursosActualizados > 1 ? "s" : "") . " ha"
                        . ($totalContadorCursosActualizados > 1 ? "n" : "") . " cambiado al estado de respuesta realizada.", "", "info-sign info icon-size-large"];
                } elseif ($totalContadorCursosActualizados > 0) {
                    $logEnvios[] = [$totalContadorCursosActualizados . " Curso" . ($totalContadorCursosActualizados > 1 ? "s" : "") .
                        " no se ha" . ($totalContadorCursosActualizados > 1 ? "n" : "") .
                        " actualizado como respuesta realizada.", "", "exclamation-sign info icon-size-large"];
                }
            }
            //Actualizamos las tablas de forma automática y añadimos los logs
            $logSolicitudesRecibidas = SolicitudesRecibidas::crearComunidadesCursillos($comunidadesDestinatarias, $totalCursosActualizadosIds);
            //Obtenemos el último registro del log generado.

            if (count($logSolicitudesRecibidas) > 0) {
                $logEnvios[] = $logSolicitudesRecibidas[count($logSolicitudesRecibidas) - 1];
            }
            //Path dónde se guarda el log de nuestras solicitudes
            $logPath = 'logs/NR/NR_log_' . date('d_m_Y_H_i_s');
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
            $logArchivo[] = "Finalización: " . date("d/m/Y H:i:s", strtotime('now'));
            //Guardamos a archivo
            file_put_contents($logPath, $logArchivo, true);
        }
        //Ponemos un download para el log en la vista
        $logEnvios[] = ["Log de nuestras respuestas.", $logPath, "", "Log"];
        //Finalizamos las respuestas
        $logEnvios[] = [end($logArchivo), "", "time green icon-size-large"];

        $titulo = "Operaciones Realizadas";
        return view('nuestrasRespuestas.listadoLog',
            compact('titulo', 'logEnvios'));
    }

    /*
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function respuestasSinSolicitudes(Request $request)
    {
        $titulo = "Respuestas sin Solicitud";
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false, '', false);
        $restoComunidades = ["" => "----------"] + Comunidades::getComunidadesList(false, false);
        $anyos = array();
        $cursillos = array();
        return view("respuestasSinSolicitudes.index", compact(
            'titulo',
            'nuestrasComunidades',
            'restoComunidades',
            'anyos',
            'cursillos'));
    }

    public function enviarRespuestasSinSolicitudes(Request $request)
    {
        $comunidadesDestinatarias = $request->get('comunidadesDestinatarias');
        $comunidadRemitente = $request->get('nuestrasComunidades');
        $cursos = $request->get('cursos');
        if (count($cursos) == 0) {
            return redirect()->route("respuestasSinSolicitudes")
                ->with("mensaje", "No hay cursos seleccionados.");
        }
        foreach ($comunidadesDestinatarias as $idx => $comunidadesDestinataria) {
            try {
                DB::transaction(function () use ($cursos, $comunidadRemitente, $comunidadesDestinataria) {
                    //Creamos una nueva instancia al modelo.
                    $solicitudEnviada = new SolicitudesEnviadas();
                    //Asignamos valores traidos del formulario.
                    $solicitudEnviada->comunidad_id = $comunidadesDestinataria;
                    $solicitudEnviada->aceptada = true;
                    $solicitudEnviada->esManual = true;
                    $solicitudEnviada->activo = true;

                    $solicitudEnviada->save();
                    foreach ($cursos as $curso) {
                        $solicitudesEnviadasCursillos[] = new SolicitudesEnviadasCursillos(['cursillo_id' => $curso]);
                    }
                    $solicitudEnviada->solicitudes_enviadas_cursillos()->saveMany($solicitudesEnviadasCursillos);
                });
            } catch (\Exception $e) {
                return redirect('respuestasSinSolicitudes')->
                with('mensaje', 'No se ha podido crear las respuestas');
            }
        }
        return redirect()->action("SolicitudesEnviadasController@index")
            ->with("mensaje", "Se han creado las respuesta con sus cursos asociados.");
    }
}

