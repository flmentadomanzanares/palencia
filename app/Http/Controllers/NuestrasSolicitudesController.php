<?php namespace Palencia\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Http\Requests;
use Illuminate\Http\Request;

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
        $anyos = Cursillos::getAnyoCursillosList();
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

    public function enviar(Request $request)
    {
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        $destinatarios = Comunidades::getComunidadPDF($request->get('restoComunidades'));
        $cursillos = Cursillos::getCursillosPDF($request->get('nuestrasComunidades'), $request->get('anyo'), $request->get('semana'));
        $numeroDestinatarios = count($destinatarios);
        if (count($remitente) == 0 || $numeroDestinatarios == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasSolicitudes.index')->
            with('mensaje', 'No se puede realizar el envío,comprueba  el remitente y/o destinatario/s  y/o curso/s');
        }
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];
        foreach ($destinatarios as $idx => $destinatario) {
            $nombreArchivo = "NS-" . date("d_m_Y", strtotime('now')) . '-' . ($destinatario->pais . '-' . $destinatario->comunidad) . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            $pathNombreArchivo = 'solicitudesCursillos\\' . $nombreArchivo;
            $cursos = [];
            $esCarta = true;
            foreach ($cursillos as $idx => $cursillo) {
                if ($cursillo->comunidad_id == $remitente->id) {
                    $cursos[] = sprintf("Nº %6s de fecha %10s al %10s", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)));
                }
            }
            if ((strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) > 0)) {
                $nombreArchivoAdjuntoEmail = 'templatePdf\\NS-' . $remitente->comunidad . '.pdf';
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), [], 'UTF-8')->save(mb_convert_encoding($nombreArchivoAdjuntoEmail, 'ISO-8859-1', 'UTF-8'));
                    $logEnvios[] = ["Creado fichero adjunto para el email de solicitud para " . $destinatario->comunidad, "", true];
                } catch (\Exception $e) {
                    $logEnvios[] = ["Error al crear el fichero adjunto para el email de " . $destinatario->comunidad, "", false];
                }
                try {
                    $envio = Mail::send('nuestrasSolicitudes.pdf.cartaSolicitudA1',
                        compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'),
                        function ($message) use ($remitente, $destinatario, $nombreArchivoAdjuntoEmail) {
                            $message->from($remitente->email_solicitud, $remitente->comunidad);
                            $message->to($destinatario->email_envio)->subject("Nuestra Solicitud");
                            $message->attach($nombreArchivoAdjuntoEmail);
                        });
                } catch (\Exception $e) {
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? ["Enviado email de solicitud a " . $destinatario->comunidad . " al correo " . $destinatario->email_envio, "", true] :
                    ["Fallo al enviar solicitud a " . $destinatario->comunidad . " al correo " . (strlen($destinatario->email_envio) > 0 ? $destinatario->email_envio : "(Sin determinar)"), "", false];
            } else {
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    if (count($destinatarios) > 1) {
                        $pdf->loadView('nuestrasSolicitudes.pdf.cartaSolicitudA2_A3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'))->save(mb_convert_encoding($pathNombreArchivo, 'ISO-8859-1', 'UTF-8'));
                        $logEnvios[] = ["Creada carta de solicitud  para " . $destinatario->comunidad, str_replace("\\", "/", $pathNombreArchivo), "", true];
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
