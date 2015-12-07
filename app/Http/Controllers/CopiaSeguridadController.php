<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Palencia\Entities\Comunidades;
use Palencia\Http\Requests;


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
        return view('copiaSeguridad.index',
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

    public function comenzarCopia(Request $request)
    {
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        if (count($remitente) == 0) {
            return redirect()->
            route('CopiaSeguridad.index')->
            with('mensaje', 'No se puede realizar el envío, selecciona comunidad.');
        }
        $logEnvios = [];
        //Ruta para linux
        $backupfile = "backups/CS-PALENCIA_" . date("Y-m-d_H_i_s") . '.sql';

        $dbhost = env('DB_HOST');
        $dbuser = env('DB_USERNAME');
        $dbpass = env('DB_PASSWORD');
        $dbname = env('DB_DATABASE');
        //Realizamos la copia de seguridad
        system("mysqldump --opt --hosts=" . $dbhost . " --user=" . $dbuser . " --password=" . $dbpass . "  " . $dbname . ">" . $backupfile);
        if ((strcmp($remitente->comunicacion_preferida, "Email") == 0) && (strlen($remitente->email_solicitud) > 0)) {
            try {
                $envio = Mail::send('copiaSeguridad.mensajeCopSeg', compact('remitente'), function ($message) use ($remitente, $backupfile) {
                    $message->from($remitente->email_solicitud, $remitente->comunidad);
                    $message->to($remitente->email_envio)->subject("Copia de Seguridad");
                    $message->attach($backupfile);
                });

                unlink($backupfile);
            } catch (\Exception $e) {
                $envio = 0;
            }
            $logEnvios[] = $envio > 0 ? ["Enviado vía email la copia de seguridad de la comunidad " . $remitente->comunidad . " al correo " . $remitente->email_envio, "", true] :
                ["Fallo al enviar la copia de seguridad de la comunidad " . $remitente->comunidad . " al correo " . (strlen($remitente->email_envio) > 0 ? $remitente->email_envio : "(Sin determinar)"), "", false];
        } else {
            $logEnvios[] = ["Creada copia de seguridad para la comunidad  " . $remitente->comunidad, $backupfile, true];
        }
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
