<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;


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
        $nuestrasComunidades = Comunidades::getComunidadesList(true, false, '', false);
        return view('copiaSeguridad.index',
            compact(
                'nuestrasComunidades',
                'titulo'));
    }

    public function comenzarCopia(Request $request)
    {
        $remitente = Comunidades::getComunidad($request->get('nuestrasComunidades'));
        if (count($remitente) == 0) {
            return redirect()->
            route('copiaSeguridad')->
            with('mensaje', 'No se puede realizar el env&iacute;o, selecciona comunidad.');
        }
        $logEnvios = [];
        //Ruta para linux
        $backupfile = "CS-PALENCIA_" . date("Y-m-d_H_i_s") . '.sql';
        $dbhost = env('DB_HOST');
        $dbuser = env('DB_USERNAME');
        $dbpass = env('DB_PASSWORD');
        $dbnamedb = env('DB_DATABASE');
        //Realizamos la copia de seguridad
        $fileCopiaSeguridad = "backups/" . $backupfile;
        $copiaSeguridad = "mysqldump --compact --opt --host=" . $dbhost . " --user=" . $dbuser . " --password=" . $dbpass . "    " . $dbnamedb . ">" . $fileCopiaSeguridad;
        try {
            System($copiaSeguridad);
            $logEnvios[] = ["Creada copia de seguridad para la comunidad  " . $remitente->comunidad, $fileCopiaSeguridad, true];
        } catch (\Exception $e) {
            $logEnvios[] = ["No se ha podedido acceder a la consola", "", false];
        }
        //Realizamos la copia de seguridad
        $logEnvios[] = ["Creada copia de seguridad para la comunidad  " . $remitente->comunidad, $fileCopiaSeguridad, true];
        $titulo = "Operaciones Realizadas";
        return view('copiaSeguridad.listadoLog',
            compact('titulo', 'logEnvios'));
    }
}
