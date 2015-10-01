<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield("titulo","Palencia")</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">

    {!! HTML::style('css/bootstrap.min.css') !!}
    {!! HTML::style('css/palencia.css') !!}
    {!! HTML::style('css/vendos/fullcalendar/fullcalendar.css') !!}

    @yield("css")

</head>
<body>

<div class="container-fluid">

    <div class="row"> <!-- Cabecera -->
        <img src={!!asset('img/cabecera.png')!!} alt="Responsive image" class="img-responsive block-center">
    </div>
    <!-- end Cabecera -->
    <nav role="navigation" id="barra" class="navbar navbar-inverse block-center">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Next nav links in the Navbar -->
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">

                    @if (Auth::check())

                        @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown">
                                    <a class="dropdown-toggle login" href="login" data-toggle="dropdown">Administración
                                        <strong class="caret"></strong></a>

                                    <ul role="menu" class="dropdown-menu">
                                        <li>{!!link_to('calendario', 'Calendario')!!}</li>
                                        <li>{!!link_to('comunidades', 'Comunidades')!!}</li>
                                        <li>{!!link_to('cursillos', 'Cursillos')!!}</li>
                                        <li>{!!link_to('localidades', 'Localidades')!!}</li>
                                        <li>{!!link_to('paises', 'Paises')!!}</li>
                                        <li>{!!link_to('provincias', 'Provincias')!!}</li>
                                        <li>{!!link_to('calendarioCursos', 'Planificacion')!!}</li>
                                        <li>{!!link_to('roles','Roles')!!}</li>
                                        <li>{!!link_to('solicitudesEnviadas', 'Solicitudes enviadas')!!}</li>
                                        <li>{!!link_to('solicitudesRecibidas', 'Solicitudes recibidas')!!}</li>
                                        <li>{!!link_to('usuarios', 'Usuarios')!!}</li>
                                    </ul>

                                </li>
                            </ul>
                        @endif

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle login" href="login" data-toggle="dropdown">Listados
                                    <strong class="caret"></strong></a>

                                <ul role="menu" class="dropdown-menu">
                                    <li>{!!link_to('Cursillos en el mundo', 'calendario')!!}</li>
                                    <li>{!!link_to('Intendencia para clausura', 'comunidades')!!}</li>
                                    <li>{!!link_to('Secretariado', 'cursillos')!!}</li>
                                    <li>{!!link_to('Secretariados por pais', 'localidades')!!}</li>
                                    <li>{!!link_to('Solicitudes enviadas', 'paises')!!}</li>
                                    <li>{!!link_to('Solicitudes recibidas', 'provincias')!!}</li>
                                </ul>

                            </li>
                        </ul>

                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::check())
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href=""><img
                                        style="width:32px;height:32px"
                                        src=" {!!asset('uploads/usuarios/'.Auth::user()->foto) !!}">
                                <strong>{!!Auth::user()->name!!}</strong>
                                <b class="caret"></b></a>
                            <ul role="menu" class="dropdown-menu">

                                <li><a class="" href="{{ url('/auth/logout') }}">logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="dropdown">
                            <a class="dropdown-toggle login" href="login" data-toggle="dropdown">login/sign in <strong
                                        class="caret"></strong></a>

                            <div class="dropdown-menu" style="padding: 20px;width:240px">
                                {!! FORM::open(array('url' => 'auth/login')) !!}

                                {!! FORM::label('email', 'email') !!} <br/>
                                {!! FORM::text ('email','',array("placeholder"=>"email de usuario",
                                "class"=>"form-control")) !!}
                                <br/>

                                {!! FORM::label ('password', 'contraseña') !!} <br/>
                                {!! FORM::password ('password',array("class"=>"form-control","placeholder"=>"password"))
                                !!} <br/>

                                {!! FORM::submit('login',array("class"=>"btn btn-success btn-block")) !!}
                                <br/>
                                <a class="formularioModal btn btn-default btn-block" href="">sign in</a>
                                {!! FORM::close() !!}
                            </div>
                        </li>
                        <li><a href="#">&nbsp;</a></li>

                    @endif
                </ul>

            </div>
        </div>
    </nav>
</div>

<div class="row margen-mensajes">
    <div class="col-md-12">
        @if(Session::has('mensaje'))
            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="close"><span
                            aria-hidden="true">&times;</span></button>
                <strong>¡Aviso!</strong> {!! Session::get('mensaje') !!}
            </div>

        @endif
        @if($errors->has())
            <div id="errores" class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <strong>Errores</strong>
                <ol>
                    @foreach ($errors->all('<p>:message</p>') as $message)
                        <li>{!! $message !!}</li>
                    @endforeach
                </ol>
            </div>
        @endif

        <h1 class="text-center margen-titulo">@yield ('titulo')</h1>

        @yield("contenido")
    </div>
</div>
<footer>
    <div class="row">

        <div class="col-xs-12 col-sm-3">
            <p class="centrar">&copy; Palencia | desarrollado por KOALNET - 2015</p>
        </div>
        <!-- end col-sm-4 -->

        <div class="col-sm-offset-1 col-xs-12 col-sm-2 text-center">
            <p><a href="{!!asset('aboutus')!!}">quienes somos</a></p>
        </div>
        <!-- end col-sm-2 -->

        <div class="col-xs-12 col-sm-1 text-center">
            <p><a href="{!!asset('contacto')!!}">contactanos</a></p>
        </div>
        <!-- end col-sm-2 -->
        <div class=" col-sm-offset-3 col-xs-12 col-sm-2 ">
            <p class="text-center"><a href="#"
                                      target="_blank"><img src="{!!asset('img/footer/icono-fb.png')!!}" alt="Facebook"
                                                           class="redes"/></a>
                <a href="#" target="_blank"><img src="{!!asset('img/footer/icono-twitter.png')!!}"
                                                 alt="Twitter" class="redes"/></a>
                <a href="#" target="_blank"><img
                            src="{!!asset('img/footer/icono-googleplus.png')!!}" alt="Google+" class="redes"/></a></p>
        </div>
    </div>
    <!-- end row -->
</footer>

<!-- jQuery -->
{!! HTML::script('js/jquery-2.1.1.js') !!}
<!-- Bootstrap JavaScript -->
{!! HTML::script('js/bootstrap.min.js') !!}
<!--User JavaScript -->
{!! HTML::script("js/comun/spinner.js")!!}
{!! HTML::script("js/vendor/fullcalendar/moment.min.js")!!}
{!! HTML::script("js/vendor/fullcalendar/fullcalendar.js")!!}
{!! HTML::script("js/comun/calendar.js")!!}
@yield("js")
</body>
</html>
