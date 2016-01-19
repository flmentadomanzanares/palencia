<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
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
        $titulo = "Nuestras Respuestas";
        $nuestrasComunidades = Comunidades::getComunidadesList(1, false, '', false);
        $restoComunidades = Comunidades::getComunidadesList(0, true, "Resto Comunidades.....", true);
        $tipos_comunicaciones_preferidas = TiposComunicacionesPreferidas::getTipoComunicacionesPreferidasList("Cualquiera");
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
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'), 0, true);
        $tipoEnvio = $request->get("modalidad");
        if ($tipoEnvio != 1) {
            $incidencias = array();
            foreach ($destinatarios as $idx => $destinatario) {
                if ($destinatario->comunicacion_preferida == "Email" && (strlen($destinatario->email_envio) == 0)) {
                    $incidencias[] = "La comunidad destinataria " . $destinatario->comunidad . " carece de email para el envío de nuestras respuestas";
                }
            }
            if (count($incidencias) > 0) {
                $tipos_comunicaciones_preferidas = $request->get('modalidad');
                $nuestrasComunidades = $request->get('nuestrasComunidades');
                $anyos = $request->get('anyo');
                $incluirRespuestasAnteriores = $request->get('incluirRespuestasAnteriores');
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
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'), 0, true);
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
        //Flag usado en el log.
        $actualizarCursillosLog = false;
        //Colección de cursos que van a ser actualizados y sus correspondiente mensajes.
        $totalCursosActualizadosIds = [];
        $totalCursosActualizados = [];
        $totalContadorCursosActualizados = 0;
        //Flag usado para realizar la operación de actualizado de los cursos que requieren de respuesta.
        $actualizarCursillos = false;
        //PDF en múltiples páginas
        $destinatariosConCarta = 0;
        $destinatariosConEmail = 0;
        $multiplesPdf = \App::make('dompdf.wrapper');
        $multiplesPdfBegin = '<html lang="es">';
        $multiplesPdfContain = "";
        $multiplesPdfEnd = '</html>';

        //Ampliamos el tiempo de ejecución del servidor a 60 minutos.
        ini_set("max_execution_time", 6000);
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
            $contadorCursosActualizados = 0;
            $esCarta = true;
            foreach ($cursillos as $idx => $cursillo) {
                if ($cursillo->comunidad_id == $destinatario->id) {
                    $cursos[] = sprintf("Nº %'06s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                    if (!$cursillo->esRespuesta) {
                        $cursosActualizados[] = sprintf("Cuso Nº %'06s de la comunidad %10s cambiado al estado de es respuesta.", $cursillo->num_cursillo, $destinatario->comunidad);
                        $cursosActualizadosIds[] = $cursillo->id;
                        $contadorCursosActualizados += 1;
                    }
                }
            }
            // $tipoEnvio si es distinto de carta , si su comunicación preferida es email y si tiene correo destinatario para el envío
            if ($tipoEnvio != 1 && (strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_envio) > 0)) {
                $archivoEmail = 'templatePDF' . $separatorPath . 'NR-' . $remitente->comunidad . '.pdf';
                //Conversión a UTF
                $nombreArchivoAdjuntoEmail = mb_convert_encoding($archivoEmail, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
                $nombreArchivoAdjuntoEmail = str_replace(" ", "", $nombreArchivoAdjuntoEmail);
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                            , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                        ))->render();
                    $pdf->loadHTML($multiplesPdfBegin . $view . $multiplesPdfEnd);
                    $pdf->output();
                    $pdf->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = ["Creado fichero adjunto para el email de respuesta a la comunidad " . $destinatario->comunidad, "", "floppy-saved", true];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el fichero adjunto para email de " . $destinatario->comunidad, "", false];
                }
                $esCarta = false;
                try {
                    $destinatario->email_solicitud = "franciscomentadomanzanares@gmail.com";
                    $destinatario->email_envio = "franciscomentadomanzanares@gmail.com";
                    $envio = Mail::send("nuestrasRespuestas.pdf.cartaRespuestaB1",
                        ['cursos' => $cursos, 'remitente' => $remitente, 'destinatario' => $destinatario, 'fecha_emision' => $fecha_emision, 'esCarta' => $esCarta]
                        , function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                            $message->from($remitente->email_envio, $remitente->comunidad);
                            $message->to($destinatario->email_envio)->subject("Nuestra Respuesta");
                            $message->attach($nombreArchivoAdjuntoEmail);
                        });
                    $destinatariosConEmail += 1;
                    $totalContadorCursosActualizados += $contadorCursosActualizados;
                    $actualizarCursillos = true;
                    foreach ($cursosActualizados as $actualizados) {

                    }
                    array_push($totalCursosActualizados, $cursosActualizados);
                    array_push($totalCursosActualizadosIds, $cursosActualizadosIds);
                    unlink($nombreArchivoAdjuntoEmail);
                } catch (\Exception $e) {
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviada respuesta a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_envio, "", "envelope", true] :
                    ["No se pudo enviar la respuesta a la comunidad " . $destinatario->comunidad . " al email " . $destinatario->email_envio, "", "envelope", false];
            } elseif ($tipoEnvio != 1 && (strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_envio) == 0)) {
                $logEnvios[] = ["La comunidad destinataria " . $destinatario->comunidad . " no dispone de email de respuesta", "", "envelope", false];
            } elseif ($tipoEnvio != 2 && (strcmp($destinatario->comunicacion_preferida, "Email") != 0)) {
                try {
                    $view = \View::make('nuestrasRespuestas.pdf.cartaRespuestaB2_B3',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'
                            , 'listadoPosicionInicial', 'listadoTotal', 'listadoTotalRestoPagina', 'separacionLinea'
                        ))->render();
                    $multiplesPdfContain .= $view;
                    $logEnvios[] = ["Creada carta de respuesta para la comunidad " . $destinatario->comunidad, "", "align-justify", true];
                    $destinatariosConCarta += 1;
                    $actualizarCursillos = true;
                    $totalContadorCursosActualizados += $contadorCursosActualizados;
                    array_push($totalCursosActualizados, $cursosActualizados);
                    array_push($totalCursosActualizadosIds, $cursosActualizadosIds);
                } catch (\Exception $e) {
                    $logEnvios[] = ["No se ha podido crear la carta de respuesta para la comunidad " . $destinatario->comunidad, "", "align-justify", false];
                }
            }
        }
        if ($destinatariosConCarta > 0) {
            $pathTotalComunidadesCarta = $path . $separatorPath . "NR-" . date("d_m_Y", strtotime('now')) . '-' . "TotalComunidadesCarta.pdf";
            $multiplesPdf->loadHTML($multiplesPdfBegin . $multiplesPdfContain . $multiplesPdfEnd);
            $multiplesPdf->output();
            $multiplesPdf->save($pathTotalComunidadesCarta);
            $logEnvios[] = ["Creada cartas de respuesta.", $pathTotalComunidadesCarta, "list-alt", true];
        }
        if (count($logEnvios) == 0) {
            $logEnvios[] = ["No hay operaciones que realizar.", "", "remove-sign", false];
        } else {
            if ($destinatariosConEmail > 0) {
                $logEnvios[] = [$destinatariosConEmail . ($destinatariosConEmail > 1 ? " emails enviados." : " email enviado"), "", "send", true];
            }
            if ($destinatariosConCarta > 0) {
                $logEnvios[] = [$destinatariosConCarta . ($destinatariosConCarta > 1 ? " cartas creadas." : " carta creada."), "", "ok", true];
            }
            //Cambiamos de estado las respuestas que no están como esRespuesta
            if ($actualizarCursillos) {
                dd($totalCursosActualizadosIds);
                if (Cursillos::setCursillosEsRespuesta($totalCursosActualizadosIds[0]) == $totalContadorCursosActualizados && $totalContadorCursosActualizados > 0) {
                    $logEnvios[] = [count($cursosActualizados) . " Curso" . ($contadorCursosActualizados > 1 ? "s" : "") . " de la comunidad " . $destinatario->comunidad . " ha"
                        . ($contadorCursosActualizados > 1 ? "n" : "") . " sido actualizado" . ($contadorCursosActualizados > 1 ? "s" : "") . " como Respuesta.", "", "thumbs-up", true];
                    $actualizarCursillosLog = true;
                } elseif ($contadorCursosActualizados > 0) {
                    $logEnvios[] = [count($cursosActualizados) . " Cursos de la comunidad " . $destinatario->comunidad . " no se ha" . ($contadorCursosActualizados > 1 ? "n" : "") .
                        " podido actualizar como Respuesta.", "", "thumbs-down", false];
                }
            }
            //Creamos el Log
            $logArchivo = array();
            $logArchivo[] = date('d/m/Y H:i:s') . "\n";
            foreach ($logEnvios as $log) {
                $logArchivo[] = $log[0] . "\n";
            }

            if ($actualizarCursillosLog) {
                foreach ($cursosActualizados as $log) {
                    $logArchivo[] = $log . "\n";
                }
            }
            //Guardamos a archivo
            file_put_contents('logs/NR_log_' . date('d_m_Y_H_i_s'), $logArchivo, true);
        }
        $titulo = "Operaciones Realizadas";
        return view('nuestrasRespuestas.listadoLog',
            compact('titulo', 'logEnvios'));
    }
}
