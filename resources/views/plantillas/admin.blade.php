<!DOCTYPE html>
<html lang="es">
<head>
    <title>@yield("titulo","Palencia")</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    {!! HTML::style('css/palencia.css') !!}
    {!! HTML::style('css/vendor/fullcalendar/fullcalendar.css') !!}
    {!! HTML::script('js/jquery-2.1.1.js') !!}
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
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if (Auth::check())
                    @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                        <ul class="nav navbar-nav">
                            <li><a href="{{ url('inicio') }}"><span class="glyphicon glyphicon-home"></span> <span
                                            class="sr-only">(current)</span></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Administrador<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>{!!link_to('comunidades', 'Comunidades')!!}</li>
                                    <li>{!!link_to('cursillos', 'Cursillos')!!}</li>
                                    <li>{!!link_to('estadosSolicitudes', 'Estados solicitudes')!!}</li>
                                    <li>{!!link_to('localidades', 'Localidades')!!}</li>
                                    <li>{!!link_to('paises', 'Paises')!!}</li>
                                    <li>{!!link_to('provincias', 'Provincias')!!}</li>
                                    <li>{!!link_to('calendarioCursos', 'Planificacion')!!}</li>
                                    <li>{!!link_to('roles','Roles')!!}</li>
                                    <li>{!!link_to('solicitudes', 'Solicitudes')!!}</li>
                                    <li>{!!link_to('tiposComunicacionesPreferidas', 'Tipos Comunicaciones
                                        Preferidas')!!}
                                    </li>
                                    <li>{!!link_to('tiposCursillos', 'Tipos Cursillos')!!}</li>
                                    <li>{!!link_to('tiposParticipantes', 'Tipos Participantes')!!}</li>
                                    <li>{!!link_to('tiposSecretariados', 'Tipos Secretariados')!!}</li>
                                    <li>{!!link_to('usuarios', 'Usuarios')!!}</li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">Listados<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>{!!link_to('pdf', 'Cursillos en el mundo')!!}</li>
                                    <li>{!!link_to('#', 'Intendencia para clausura')!!}</li>
                                    <li>{!!link_to('#', 'Secretariado')!!}</li>
                                    <li>{!!link_to('#', 'Secretariados por pais')!!}</li>
                                    <li>{!!link_to('#', 'Solicitudes enviadas')!!}</li>
                                    <li>{!!link_to('#', 'Solicitudes recibidas')!!}</li>
                                </ul>
                            </li>
                        </ul>
                    @endif
                @endif
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
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</div>

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
    <h1 class="text-center">@yield ('titulo')</h1>
    @yield("contenido")
<footer>
        <span>&copy; Palencia | desarrollado por KOALNET - 2015</span>
</footer>
{!! HTML::script('js/bootstrap.min.js') !!}
{!! HTML::script("js/comun/spinner.js")!!}
@yield("js")
</body>
</html>
