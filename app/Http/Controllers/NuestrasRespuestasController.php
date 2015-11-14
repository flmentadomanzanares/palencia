<?php namespace Palencia\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Entities\Cursillos;
use Palencia\Http\Requests;
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
        $cursillos = Cursillos::getCursillosPDF($request->get('restoComunidades'), $request->get('anyo'), $request->get('semana'));
        if (count($remitente) == 0 || count($destinatarios) == 0 || count($cursillos) == 0) {
            return redirect()->
            route('nuestrasRespuestas.index')->
            with('mensaje', 'No se puede realizar el envío,comprueba  el remitente y/o destinatario/s.');
        }
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha_emision = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
        $logEnvios = [];

        foreach ($destinatarios as $idx => $destinatario) {
            $nombreArchivo = "NR-" . date("d_m_Y", strtotime('now')) . '-' . $destinatario->pais . '-' . $destinatario->comunidad . '-' . ($request->get('anyo') > 0 ? $request->get('anyo') : 'TotalCursos') . '.pdf';
            $cursos = [];
            $esCarta = true;
            foreach ($cursillos as $idx => $cursillo) {
                if ($cursillo->comunidad_id == $destinatario->id) {
                    $cursos[] = sprintf("Nº %6s de fecha %10s al %10s [Sem:%2d]", $cursillo->num_cursillo, date('d/m/Y', strtotime($cursillo->fecha_inicio)), date('d/m/Y', strtotime($cursillo->fecha_final)), $cursillo->semana);
                }
            }

            try {
                //return view('nuestrasRespuestas.pdf.cartaRespuestaB3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'));
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), [], 'UTF-8')->save('respuestasCursillos\\' . $nombreArchivo);
                $logEnvios[] = "Creada carta de respuesta para " . $destinatario->comunidad;
            } catch (\Exception $e) {
                $logEnvios[] = "Error al crear la carta de respuesta para " . $destinatario->comunidad;
            }
            if ((strcmp($destinatario->comunicacion_preferida, "Email") == 0) && (strlen($destinatario->email_solicitud) > 0)) {
                $esCarta = false;
                $nombreArchivoAdjuntoEmail = 'templatePdf\\NR-' . $remitente->comunidad . '.pdf';
                try {
                    $pdf = \App::make('dompdf.wrapper');
                    $pdf->loadView('nuestrasRespuestas.pdf.cartaRespuestaB2_B3', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), [], 'UTF-8')->save($nombreArchivoAdjuntoEmail);
                    $logEnvios[] = "Creado fichero adjunto para el email de respuesta de ". $destinatario->comunidad;
                } catch (\Exception $e) {
                    $logEnvios[] = "Error al crear el fichero adjunto para email de ". $destinatario->comunidad;
                }
                try {
                    $envio = Mail::send('nuestrasRespuestas.pdf.cartaRespuestaB1', compact('cursos', 'remitente', 'destinatario', 'fecha_emision', 'esCarta'), function ($message) use ($nombreArchivo, $destinatario, $nombreArchivoAdjuntoEmail) {
                        $message->from($destinatario->email_envio, $destinatario->comunidad);
                        $message->to($destinatario->email_solicitud)->subject("Nuestra Respuesta")->cc('antonio_sga@yahoo.es');
                        $message->attach($nombreArchivoAdjuntoEmail);
                    });
                } catch (\Exception $e) {
                    $envio = 0;
                }
                $logEnvios[] = $envio > 0 ? "Enviado email de respuesta a " . $destinatario->comunidad . " al correo " . $destinatario->email_solicitud :
                    "Fallo al enviar respuesta a " . $destinatario->comunidad . " al correo " . (strlen($destinatario->email_solicitud) > 0 ? $destinatario->email_solicitud : "(Sin determinar)");
            }
        }
        $titulo = "Operaciones Realizadas";
        return view('nuestrasRespuestas.listadoLog',
            compact('titulo', 'logEnvios'));
    }


}
