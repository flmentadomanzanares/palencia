<?php namespace Palencia\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Illuminate\Http\Request;

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
        $restoComunidades = Comunidades::getComunidadesList(0, false, '', true);
        $anyos = Cursillos::getAnyoCursillosList();
        $semanas = Array();
        $cursillos = Array();
        return view('nuestrasRespuestas.index',
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
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'));
        $cursillos = Cursillos::getCursillosPDF($request->get('restoComunidades'), $request->get('anyo'), $request->get('semana'));
        if (count($remitente) == 0 || count($destinatarios) == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasRespuestas')->
            with('mensaje', 'No se puede realizar el envío,comprueba  el remitente y/o destinatario/s  y/o curso/s');
        }
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];
        //Ampliamos el tiempo de ejecución del servidor a 3 minutos.
        ini_set("max_execution_time", 300);
        foreach ($destinatarios as $idx => $destinatario) {
            $archivo = "respuestasCursillos/NR-" . date("d_m_Y", strtotime('now')) . '-' . $destinatario->pais . '-' . $destinatario->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            $nombreArchivo = mb_convert_encoding($archivo, 'ISO-8859-1', 'UTF-8');
            $cursos = [];
            $esCarta = true;
            foreach ($cursillos as $idx => $cursillo) {
                if ($cursillo->comunidad_id == $destinatario->id) {
                    $cursos[] = sprintf("Nº %6s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                }
            }

            if ((strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) > 0)) {
                $esCarta = false;
                $nombreArchivoAdjuntoEmail = mb_convert_encoding('templatePDF/NR-' . $remitente->comunidad . '.pdf', 'ISO-8859-1', 'UTF-8');
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), [], 'UTF-8')->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = ["Creado fichero adjunto para el email de respuesta de " . $destinatario->comunidad, "", true];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el fichero adjunto para email de " . $destinatario->comunidad, "", false];
                }
                try {
                    $envio = Mail::send("nuestrasRespuestas.pdf.cartaRespuestaB1",
                        ['cursos'=>$cursos, 'remitente'=>$remitente, 'destinatario'=>$destinatario, 'fecha_emision'=>$fecha_emision, 'esCarta'=>$esCarta]
                        , function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                        $message->from($remitente->email_solicitud, $remitente->comunidad);
                        $message->to($destinatario->email_envio)->subject("Nuestra Respuesta");
                        $message->attach($nombreArchivoAdjuntoEmail);
                    });
                    unlink($nombreArchivoAdjuntoEmail);
                } catch (\Exception $e) {
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviado email de respuesta a " . $destinatario->comunidad . " al correo " . $destinatario->email_envio, "", true] :
                    ["Fallo al enviar respuesta a " . $destinatario->comunidad . " al correo " . (strlen($destinatario->email_envio) > 0 ? $destinatario->email_envio : "(Sin determinar)"), "", false];
            } else {
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    if (count($destinatarios) > 1) {
                        $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->save($nombreArchivo);
                        $logEnvios[] = ["Creada carta de respuesta para " . $destinatario->comunidad, $nombreArchivo, "", true];
                    } else {
                        return $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->download($nombreArchivo);
                    }
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear la carta de respuesta para " . $destinatario->comunidad, "", false];
                }
            }
        }

        $titulo = "Operaciones Realizadas";
        return view('nuestrasRespuestas.listadoLog',
            compact('titulo', 'logEnvios'));
    }
}
