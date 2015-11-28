<?php namespace Palencia\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Http\Requests;
use Illuminate\Http\Request;

class CopiaSeguridadController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $titulo = "Copia Seguridad";
        $nuestrasComunidades = Comunidades::getComunidadesList(1, false, '', false);
        return view('nuestrasRespuestas.index',
            compact(
                'nuestrasComunidades',
                'titulo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    public function CrearCopia(Request $request)
    {
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        if (count($remitente) == 0) {
            return redirect()->
            route('CopiaSeguridad.index')->
            with('mensaje', 'No se puede realizar el envío, selecciona comunidad.');
        }

        $logEnvios = [];

        $cursos = [];

        /*
                    if ((strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) > 0)) {
                        $esCarta = false;
                        $nombreArchivoAdjuntoEmail = 'templatePdf\\NR-' . $remitente->comunidad . '.pdf';
                        try {
                            $pdf = \App::make('dompdf.wrapper');
                            $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), [], 'UTF-8')->save(mb_convert_encoding($nombreArchivoAdjuntoEmail, 'ISO-8859-1', 'UTF-8'));
                            $logEnvios[] = ["Creado fichero adjunto para el email de respuesta de " . $destinatario->comunidad, "", true];
                        } catch (\Exception $e) {
                            $logEnvios[] = ["Error al crear el fichero adjunto para email de " . $destinatario->comunidad, "", false];
                        }
                        try {
                            $envio = Mail::send('nuestrasRespuestas.pdf.cartaRespuestaB1', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                                $message->from($remitente->email_solicitud, $remitente->comunidad);
                                $message->to($destinatario->email_envio)->subject("Nuestra Respuesta");
                                $message->attach($nombreArchivoAdjuntoEmail);
                            });
                        } catch (\Exception $e) {
                            $envio = 0;
                        }
                        $logEnvios[] = $envio > 0 ? ["Enviado email de respuesta a " . $destinatario->comunidad . " al correo " . $destinatario->email_envio, "", true] :
                            ["Fallo al enviar respuesta a " . $destinatario->comunidad . " al correo " . (strlen($destinatario->email_envio) > 0 ? $destinatario->email_envio : "(Sin determinar)"), "", false];
                    } else {
                        try {
                            $pdf = \App::make('dompdf.wrapper');
                            if (count($destinatarios) > 1) {
                                $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->save(mb_convert_encoding($pathNombreArchivo, 'ISO-8859-1', 'UTF-8'));
                                $logEnvios[] = ["Creada carta de respuesta para " . $destinatario->comunidad, str_replace("\\", "/", $pathNombreArchivo), "", true];
                            } else {
                                return $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->download($nombreArchivo);
                            }
                            return $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->download($nombreArchivo);
                        } catch (\Exception $e) {
                            $logEnvios[] = ["Error al crear la carta de respuesta para " . $destinatario->comunidad, "", false];
                        }
                    }
                }
        */
        $titulo = "Operaciones Realizadas";
        return view('copiaSeguridad.listadoLog',
            compact('titulo', 'logEnvios'));
    }

    private function DescargarArchivo($fichero)
    {
        $archivo = basename($fichero);
        $ruta = 'respuestasCursillos/' . $archivo;
        if (is_file($ruta)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . $archivo);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($ruta));
            readfile($ruta);
        }

    }

}
