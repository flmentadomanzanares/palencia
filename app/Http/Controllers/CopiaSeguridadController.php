<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
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
        $backupfile = "CS-PALENCIA_" . date("Y-m-d_H_i_s") . '.sql';

        $dbhost = env('DB_HOST');
        $dbuser = env('DB_USERNAME');
        $dbpass = env('DB_PASSWORD');
        $dbnamedb = env('DB_DATABASE');
        //Realizamos la copia de seguridad
        $fileCopiaSeguridad = "backups/" . $backupfile;
        $copiaSeguridad = "mysqldump --compact --opt --host=" . $dbhost . " --user=" . $dbuser . " --password=" . $dbpass . "    " . $dbnamedb . ">" . $fileCopiaSeguridad;
        System($copiaSeguridad);
        //Realizamos la copia de seguridad
        $logEnvios[] = ["Creada copia de seguridad para la comunidad  " . $remitente->comunidad, $fileCopiaSeguridad, true];
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
