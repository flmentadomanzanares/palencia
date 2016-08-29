<?php namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

trait AuthenticatesAndRegistersUsers
{

    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * The registrar implementation.
     *
     * @var \Illuminate\Contracts\Auth\Registrar
     */
    protected $registrar;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        if (config('opciones.verificar.Email')) {
            //Añadimos a la request nuevos parámetros a incluir en el usuario a crear
            $codigoConfirmacion = str_random(30);
            $request->request->add(['activo' => "1", 'confirmado' => "0", "codigo_confirmacion" => $codigoConfirmacion]);
            try {
                $envio = Mail::send('emails.verificacion', ["codigoConfirmacion" => $codigoConfirmacion], function ($message) use ($request) {
                    $message->from($request->get('email'));
                    $message->to($request->get('email'))->subject('Verifica tu dirección de correos.');
                });
            } catch (\Exception $ex) {
                $envio = 0;
            }
            if ($envio == 0) {
                return Redirect('/')->with('mensaje', 'No se ha podido enviar el email de confirmación a tu cuenta de correos.Comprueba cortafuegos y/o antivirus.');
            }
            $this->registrar->create($request->all());
            return Redirect('/')->with('mensaje', 'Gracias por darte de alta, Por favor verifica tu cuenta de correos.');
        } else {
            $request->request->add(['activo' => "1", 'confirmado' => "1", "codigo_confirmacion" => null]);
            $this->auth->login($this->registrar->create($request->all()));
            return redirect($this->redirectPath());
        }
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/inicio';
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('invitado');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $error = $this->auth->attempt($credentials, $request->has('remember'));
        switch ($error) {
            case 0:
                return redirect()->intended($this->redirectPath());
            case -1:
            case 1:
                return redirect($this->loginPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getFailedLoginMessage(),
                    ]);
            case 2:
                return redirect($this->loginPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getNoActiveUserMessage(),
                    ]);
            case 3:
                return redirect($this->loginPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getNoConfirmationMessage(),
                    ]);
        }
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/';
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'email y/o password no coinciden.';
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    private function getNoActiveUserMessage()
    {
        return 'El usuario no está activo, ponte en contacto con el administrador.';
    }

    /**
     * Get no confirmation  message.
     *
     * @return string
     */
    private function getNoConfirmationMessage()
    {
        return 'Valida tu cuenta desde tu email.';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
}
