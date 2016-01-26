<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Cursillos;
use Palencia\Entities\SolicitudesEnviadas;
use Palencia\Entities\SolicitudesEnviadasCursillos;
use Palencia\Entities\SolicitudesRecibidas;
use Palencia\Entities\SolicitudesRecibidasCursillos;
use Palencia\Http\Requests;
use Illuminate\Support\Facades\DB;


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
        $anyo = \Request::input('anyo');

        if ($anyo == 0) {

            return redirect('cerrarAnyo')->
            with('mensaje', 'Debe seleccionar un año.');

        } else {

                try {
                    $solicitudesEnviadasCursillos = SolicitudesEnviadasCursillos::where(DB::raw('DATE_FORMAT(solicitudes_enviadas_cursillos.created_at,"%Y")'), '=', $anyo)->delete();
                } catch (\Exception $e) {
                    switch ($e->getCode()) {
                        case 23000:
                            return redirect('cerrarAnyo')->with('mensaje', 'La tabla solicitudes_enviadas_cursillos no se ha podido borrar.');
                            break;
                        default:
                            return redirect('cerrarAnyo')->with('mensaje', 'Eliminar solicitudes_enviadas_cursillos error ' . $e->getCode());
                    }
                }

                try {
                    $solicitudesEnviadas = SolicitudesEnviadas::where(DB::raw('DATE_FORMAT(solicitudes_enviadas.created_at,"%Y")'), '=', $anyo)->delete();
                } catch (\Exception $e) {
                    switch ($e->getCode()) {
                        case 23000:
                            return redirect('cerrarAnyo')->with('mensaje', 'La tabla solicitudes_enviadas no se ha podido borrar.');
                            break;
                        default:
                            return redirect('cerrarAnyo')->with('mensaje', 'Eliminar solicitudes_enviadas error ' . $e->getCode());
                    }
                }

            try {
                $solicitudesRecibidasCursillos = SolicitudesEnviadasCursillos::where(DB::raw('DATE_FORMAT(solicitudes_enviadas_cursillos.created_at,"%Y")'), '=', $anyo)->delete();
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        return redirect('cerrarAnyo')->with('mensaje', 'La tabla solicitudes_enviadas_cursillos no se ha podido borrar.');
                        break;
                    default:
                        return redirect('cerrarAnyo')->with('mensaje', 'Eliminar solicitudes_enviadas_cursillos error ' . $e->getCode());
                }
            }

            try {
                $solicitudesRecibidas = SolicitudesEnviadas::where(DB::raw('DATE_FORMAT(solicitudes_enviadas.created_at,"%Y")'), '=', $anyo)->delete();
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        return redirect('cerrarAnyo')->with('mensaje', 'La tabla solicitudes_enviadas no se ha podido borrar.');
                        break;
                    default:
                        return redirect('cerrarAnyo')->with('mensaje', 'Eliminar solicitudes_enviadas error ' . $e->getCode());
                }
            }

                try {
                    $cursillos = Cursillos::where(DB::raw('DATE_FORMAT(cursillos.fecha_final,"%Y")'), '=', $anyo)->delete();
                } catch (\Exception $e) {
                    switch ($e->getCode()) {
                        case 23000:
                            return redirect('cerrarAnyo')->with('mensaje', 'La tabla cursillos no se ha podido borrar.');
                            break;
                        default:
                            return redirect('cerrarAnyo')->with('mensaje', 'Eliminar cursillos error ' . $e->getCode());
                    }
                }


            return redirect('cerrarAnyo')->
            with('mensaje', 'Las tablas se han borrado con exito.');

        }

    }
}