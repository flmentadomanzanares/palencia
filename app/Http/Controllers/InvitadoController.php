<?php namespace Palencia\Http\Controllers;

use Palencia\Entities\User;

class InvitadoController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('invitado');
    }

    public function confirmar($codigoConfirmacion)
    {
        if (!$codigoConfirmacion) {
            return redirect()->
            route('invitado')->
            with('mensaje', 'No se ha podido validar el usuario.');
        }
        $user = User::where('codigo_confirmacion', $codigoConfirmacion)->first();
        if ($user == null) {
            return redirect()->
            route('invitado')->
            with('mensaje', 'No se ha podido validar el usuario.');
        }
        $user->confirmado = true;
        $user->codigo_confirmacion = null;
        $user->save();
        return redirect()->
        route('invitado')->
        with('mensaje', 'La verificaci&oacute;n de cuenta se ha realizado con &eacute;xito.');

    }
}
