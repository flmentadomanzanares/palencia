<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use PDO;

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
        //Realizamos la copia de seguridad

        try {
            //System($copiaSeguridad);
            $DBHOST = env('DB_HOST');
            $DBNAME = env('DB_DATABASE');
            $DBUSER = env('DB_USERNAME');
            $DBPASS = env('DB_PASSWORD');

            $zp = null;
            $tables = null;
            $handle = null;
            $compression = config('opciones.copiaDeSeguridad.usarCompresion');
            $directorio = config('opciones.copiaDeSeguridad.directorioBase');
            $separatorPath = "/";

            $DBH = new PDO("mysql:host=" . $DBHOST . ";dbname=" . $DBNAME . "; charset=utf8", $DBUSER, $DBPASS);
            if (is_null($DBH) || $DBH === FALSE) {
                die('ERROR');
            }
            $DBH->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
            $backupfile = $directorio . $separatorPath . "CS-PALENCIA_" . date("Y-m-d_H_i_s");
//create/open files
            if ($compression) {
                $backupfile .= '.' . config('opciones.copiaDeSeguridad.comprimido.extensionArchivo') . '.gz';
                $zp = gzopen($backupfile, "a9");
            } else {
                $backupfile .= '.' . config('opciones.copiaDeSeguridad.sinComprimir.extensionArchivo');
                $handle = fopen($backupfile, 'w+');
            }
//array of all database field types which just take numbers
            $numtypes = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'float', 'double', 'decimal', 'real');
//get all of the tables
            if (empty($tables)) {
                $pstm1 = $DBH->query('SHOW TABLES');
                while ($row = $pstm1->fetch(PDO::FETCH_NUM)) {
                    $tables[] = $row[0];
                }
            } else {
                $tables = is_array($tables) ? $tables : explode(',', $tables);
            }
//cycle through the table(s)
            foreach ($tables as $table) {
                $result = $DBH->query("SELECT * FROM $table");
                $num_fields = $result->columnCount();
                $num_rows = $result->rowCount();
                $return = "";
                //uncomment below if you want 'DROP TABLE IF EXISTS' displayed
                //$return.= 'DROP TABLE IF EXISTS `'.$table.'`;';
                //table structure
                $pstm2 = $DBH->query("SHOW CREATE TABLE $table");
                $row2 = $pstm2->fetch(PDO::FETCH_NUM);
                $ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
                $return .= "\n\n" . $ifnotexists . ";\n\n";
                if ($compression) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
                //insert values
                if ($num_rows) {
                    $return = 'INSERT INTO `' . "$table" . "` (";
                    $pstm3 = $DBH->query("SHOW COLUMNS FROM $table");
                    $count = 0;
                    $type = array();
                    while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {
                        if (stripos($rows[1], '(')) {
                            $type[$table][] = stristr($rows[1], '(', true);
                        } else {
                            $type[$table][] = $rows[1];
                        }
                        $return .= "`" . $rows[0] . "`";
                        $count++;
                        if ($count < ($pstm3->rowCount())) {
                            $return .= ", ";
                        }
                    }
                    $return .= ")" . ' VALUES';
                    if ($compression) {
                        gzwrite($zp, $return);
                    } else {
                        fwrite($handle, $return);
                    }
                    $return = "";
                }
                $count = 0;
                while ($row = $result->fetch(PDO::FETCH_NUM)) {
                    $return = "\n(";
                    for ($j = 0; $j < $num_fields; $j++) {
                        if (isset($row[$j])) {
                            //if number, take away "". else leave as string
                            if ((in_array($type[$table][$j], $numtypes)) && $row[$j] !== '') {
                                $return .= $row[$j];
                            } else {
                                $return .= $DBH->quote($row[$j]);
                            }
                        } else {
                            $return .= 'NULL';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return .= ',';
                        }
                    }
                    $count++;
                    if ($count < ($result->rowCount())) {
                        $return .= "),";
                    } else {
                        $return .= ");";
                    }
                    if ($compression) {
                        gzwrite($zp, $return);
                    } else {
                        fwrite($handle, $return);
                    }
                    $return = "";
                }
                $return = "\n\n-- ------------------------------------------------ \n\n";
                if ($compression) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }
            $error1 = $pstm2->errorInfo();
            $error2 = $pstm3->errorInfo();
            $error3 = $result->errorInfo();
            echo $error1[2];
            echo $error2[2];
            echo $error3[2];
            $fileSize = 0;
            if ($compression) {
                gzclose($zp);
            } else {
                fclose($handle);
            }
            $logEnvios[] = ["Creada copia de seguridad para la comunidad " . $remitente->comunidad, $backupfile, true];
        } catch (\Exception $e) {
            $logEnvios[] = ["No se ha podedido acceder a la consola." . $e->getMessage(), "", false];
        }
        //Realizamos la copia de seguridad
        $titulo = "Operaciones Realizadas";
        return view('copiaSeguridad.listadoLog',
            compact('titulo', 'logEnvios'));
    }
}
