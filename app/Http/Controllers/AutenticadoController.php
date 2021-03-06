<?php namespace Palencia\Http\Controllers;

use Illuminate\Http\Request;
use Palencia\Entities\Cursillos;

class AutenticadoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $titulo = "Calendario";
        $cursillos = Cursillos::getCalendarCursillos($request);
        $anyos = Cursillos::getAnyoCursillosList();
        //Obtenemos los parámetros de la respuesta
        $year = $request->input('anyo');
        $week = $request->input('semana') > 0 ? $request->input('semana') : 1;
        $semanas = Array();
        //A partir del número de semana obtenemos el mes
        if ($year > 0 && $week > 0) {
            $month = new \DateTime();
            $month->setISODate($year, $week);
            $mes = $month->format('m');
            $year = $month->format('Y');
        }
        $date = $year > 0 ? date('Y-m-d', strtotime("$year-$mes-1")) : date('Y-m-d');
        //Cargamos los cursillos
        foreach ($cursillos as $cursillo) {
            $event[] = \Calendar::event(
                $cursillo->comunidad,
                $cursillo->cursillo, //event title
                true, //full day event?
                $cursillo->fecha_inicio, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                date('Y-m-d', strtotime($cursillo->fecha_final) + 86400), //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $cursillo->colorFondo,
                $cursillo->colorTexto,
                $cursillo->id
            );
        }
        if (count($cursillos) > 0) {
            $calendar = \Calendar::addEvents($event)
                ->setOptions([ //set fullcalendar options
                    'lang' => '',
                    'defaultDate' => $date,
                    'buttonIcons' => true,
                    'editable' => false,
                    'weekNumbers' => true,
                    'eventLimit' => true, // allow "more" link when too many events
                    'header' => array('left' => 'prev', 'center' => 'title', 'right' => 'next')
                ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                    'eventClick' => 'function(calEvent, jsEvent, view) {
                    $(this).attr("href","curso/"+calEvent.id);
                }'
                ]);
        }
        return view('autenticado', compact('calendar', 'anyos', 'semanas', 'titulo'));
    }
}
