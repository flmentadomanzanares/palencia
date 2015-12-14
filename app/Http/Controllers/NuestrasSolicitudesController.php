<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
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
                'titulo'));
    }

    public function enviar(Request $request)
    {
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'), 0);
        $cursillos = Cursillos::getCursillosPDF($request->get('nuestrasComunidades'), $request->get('anyo'), $request->get('semana'));
        $numeroDestinatarios = count($destinatarios);
        if (count($remitente) == 0 || $numeroDestinatarios == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasSolicitudes')->
            with('mensaje', 'No se puede realizar el envío,comprueba  el remitente y/o destinatario/s  y/o curso/s');
        }
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];
        //Ampliamos el tiempo de ejecución del servidor a 3 minutos.
        ini_set("max_execution_time", 300);
        foreach ($destinatarios as $idx => $destinatario) {
            //Ruta Linux
            $archivo = "solicitudesCursillos" . "/" . "NS-" . date("d_m_Y", strtotime('now')) . '-' . $destinatario->pais . '-' . $destinatario->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            //Conversión a UTF
            $nombreArchivo = mb_convert_encoding($archivo, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
            $cursos = [];
            $esCarta = true;
            foreach ($cursillos as $idx => $cursillo) {
                if ($cursillo->comunidad_id == $remitente->id) {
                    $cursos[] = sprintf("Nº %6s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                }
            }
            if ((strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) > 0)) {
                $archivoMail = 'templatePDF' . '/' . 'NS-' . $remitente->comunidad . '.pdf';
                //Conversión a UTF
                $nombreArchivoAdjuntoEmail = mb_convert_encoding($archivoMail, "UTF-8", mb_detect_encoding($archivo, "UTF-8, ISO-8859-1, ISO-8859-15", true));
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), [], 'UTF-8')->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = ["Creado fichero adjunto para el email de solicitud para " . $destinatario->comunidad, "", true];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el fichero adjunto para el email de " . $destinatario->comunidad, "", false];
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
                $logEnvios[] = $envio > 0 ? ["Enviado email de solicitud a " . $destinatario->comunidad . " al correo " . $destinatario->email_envio, "", true] :
                    ["Fallo al enviar solicitud a " . $destinatario->comunidad . " al correo " . (strlen($destinatario->email_envio) > 0 ? $destinatario->email_envio : "(Sin determinar)"), "", false];
            } else {
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    if (count($destinatarios) > 1) {
                        $pdf->loadView('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->save($nombreArchivo);
                        $logEnvios[] = ["Creada carta de solicitud  para " . $destinatario->comunidad, $nombreArchivo, true];
                    } else {
                        return $pdf->loadView('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->download($nombreArchivo);
                    }
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear la carta de solicitud para " . $destinatario->comunidad, "", false];
                }
            }
        }
        $titulo = "Operaciones Realizadas";
        return view('nuestrasSolicitudes.listadoLog',
            compact('titulo', 'logEnvios'));

    }
}
