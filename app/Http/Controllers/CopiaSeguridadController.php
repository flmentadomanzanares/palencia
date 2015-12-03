<?php namespace Palencia\Http\Controllers;

use Illuminate\Support\Facades\Config;
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
        return view('copiaSeguridad.index', compact('nuestrasComunidades', 'titulo'));
    }

    public function comenzarCopia(Request $request)
    {
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        if (count($remitente) == 0) {
            return redirect()->
            route('copiaSeguridad')->
            with('mensaje', 'No se puede realizar el envío, selecciona comunidad.');
        }
        $logEnvios = [];
        $backupfile = "CS-PALENCIA_" . date("Y-m-d") . '.sql';

        $dbhost = env('DB_HOST');
        $dbuser = env('DB_USERNAME');
        $dbpass = env('DB_PASSWORD');
        $dbnamedb = env('DB_DATABASE');
        //Realizamos la copia de seguridad
        $fileCopiaSeguridad = "backups" . "/" . $backupfile;
        $copiaSeguridad = "mysqldump --opt --host=" . $dbhost . " --user=" . $dbuser . " --password=" . $dbpass . "   " . $dbnamedb . ">" . $fileCopiaSeguridad;

        system($copiaSeguridad);

        if ((strcmp($remitente->comunicacion_preferida, "Email") == 0) && (strlen($remitente->email_solicitud) > 0)) {
            try {
                $envio = Mail::send('copiaSeguridad.mensajeCopSeg', compact('remitente'), function ($message) use ($remitente, $fileCopiaSeguridad) {
                    $message->from($remitente->email_solicitud, $remitente->comunidad);
                    $message->to($remitente->email_envio)->subject("Copia de Seguridad");
                    $message->attach($fileCopiaSeguridad);
                });
                unlink($backupfile);
            } catch (\Exception $e) {
                $envio = 0;
            }
            $logEnvios[] = $envio > 0 ? ["Enviado vía email la copia de seguridad de la comunidad " . $remitente->comunidad . " al correo " . $remitente->email_envio, "", true] :
                ["Fallo al enviar la copia de seguridad de la comunidad " . $remitente->comunidad . " al correo " . (strlen($remitente->email_envio) > 0 ? $remitente->email_envio : "(Sin determinar)"), "", false];
        } else {
            $logEnvios[] = ["Creado fichero de copia de seguridad para la comunidad " . $remitente->comunidad, str_replace("\\", "/", $fileCopiaSeguridad), true];
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
