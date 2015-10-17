<?php namespace Palencia\Http\Controllers;

use Carbon\Carbon;
use Palencia\Entities\Cursillos;
use Illuminate\Http\Request;
use Palencia\Entities\Comunidades;
use Palencia\Http\Requests\ValidateRulesCursillos;

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
        $anyos = Cursillos::getAnyoCursillos();
        $semanas = array(array());
        $cursillos = Cursillos::getCalendarCursillos($request);
        foreach ($cursillos as $cursillo) {
            $event[] = \Calendar::event(
                $cursillo->cursillo, //event title
                true, //full day event?
                $cursillo->fecha_inicio, //start time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg)
                $cursillo->fecha_final, //end time, must be a DateTime object or valid DateTime format (http://bit.ly/1z7QWbg),
                $cursillo->color,
                $cursillo->id //optional event ID
            );
        }
        $calendar = \Calendar::addEvents($event)
            ->setOptions([ //set fullcalendar options
                'lang' => '',
                'buttonIcons' => true,
                'editable' => false,
                'weekNumbers' => true,
                'eventLimit' => true, // allow "more" link when too many events
                'header' => array('left' => 'prev,next', 'center' => 'title', 'right' => 'next,prev')
            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'eventClick' => 'function(calEvent, jsEvent, view) {
                    $(this).attr("href","cursillos/"+calEvent.id);
				}'
            ]);
        return view('autenticado', compact('calendar', 'anyos', 'semanas', 'titulo'));
    }
}
