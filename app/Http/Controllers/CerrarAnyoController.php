<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\SolicitudesEnviadasCursillos;
use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Entities\SolicitudesRecibidasCursillos;
use Palencia\Http\Requests;


class CerrarAnyoController extends Controller
{

    /*******************************************************************
     *
     *  Función para recabar el año a cerrar
     *
     *******************************************************************/
    public function getAnyo()
    {
        $titulo = "Cerrar A&ntilde;o";
        $anyos = Cursillos::getAnyoCursillosList();
        return view("cerrarAnyo.getAnyo",
            compact('titulo',
                'anyos'));

    }

    /*******************************************************************
     *
     *  Función para borrar los registros del año seleccionado
     *
     *******************************************************************/

    public function borrarTablas(Request $request)
    {
        $anyo = $request->get('anyo');
        if ($anyo == 0) {
            return redirect('cerrarAnyo')->
            with('mensaje', 'Debe seleccionar un año.');
        } else {
            try {
                DB::transaction(function () use ($anyo) {
                    SolicitudesEnviadasCursillos::where(DB::raw('DATE_FORMAT(solicitudes_enviadas_cursillos.created_at,"%Y")'), '=', $anyo)->delete();
                    SolicitudesEnviadas::where(DB::raw('DATE_FORMAT(solicitudes_enviadas.created_at,"%Y")'), '=', $anyo)->delete();
                    SolicitudesRecibidasCursillos::where(DB::raw('DATE_FORMAT(solicitudes_recibidas_cursillos.created_at,"%Y")'), '=', $anyo)->delete();
                    SolicitudesRecibidas::where(DB::raw('DATE_FORMAT(solicitudes_recibidas.created_at,"%Y")'), '=', $anyo)->delete();
                    Cursillos::where(DB::raw('DATE_FORMAT(cursillos.fecha_final,"%Y")'), '=', $anyo)->delete();
                });
            } catch (\Exception $e) {
                return redirect('cerrarAnyo')->
                with('mensaje', 'Las tablas no se han podido borrar.');
            }
        }
        return redirect('cerrarAnyo')->
        with('mensaje', 'Las tablas se han borrado con exito.');
    }
}