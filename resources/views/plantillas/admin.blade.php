<!DOCTYPE html>
<html lang="es">
<head>
    <title>Palencia</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    {!! HTML::style('css/palencia.css') !!}
    {!! HTML::style('css/vendor/fullcalendar/fullcalendar.css') !!}

    @yield("css")
</head>
<body>

<div>
    <div class="row img-header">
        <div></div>
    </div>
    <nav role="navigation" class="navbar navbar-inverse block-center">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
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
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('nuestrasRespuestas', 'Nuestras Respuestas')!!}</li>
                                <li>{!!link_to('nuestrasSolicitudes', 'Nuestras Solicitudes')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('solicitudesEnviadas', 'Solicitudes enviadas')!!}</li>
                                <li>{!!link_to('solicitudesRecibidas', 'Solicitudes recibidas')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('paises', 'Países')!!}</li>
                                <li>{!!link_to('provincias', 'Provincias')!!}</li>
                                <li>{!!link_to('localidades', 'Localidades')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('tiposSecretariados', 'Tipos Secretariados')!!}</li>

                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Listados<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>{!!link_to('cursillosPaises', 'Cursillos en el mundo')!!}</li>
                                <li>{!!link_to('intendenciaClausura', 'Intendencia para clausura')!!}</li>
                                <li>{!!link_to('secretariado', 'Secretariado')!!}</li>
                                <li>{!!link_to('secretariadosPais', 'Secretariados por pais')!!}</li>
                            </ul>
                        </li>
                    </ul>
                @endif
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li class="">
                        <a data-toggle="dropdown" class="dropdown-toggle" href=""><img
                                    class="user-image"
                                    src=" {!!asset('uploads/usuarios/'.Auth::user()->foto) !!}">
                            <strong>{!!Auth::user()->name!!}</strong>
                            <b class="caret"></b></a>
                        <ul role="menu" class="dropdown-menu">
                            @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                <li>{!!link_to('usuarios', 'Usuarios')!!}</li>
                                <li>{!!link_to('roles','Roles')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('copiaSeguridad','Copia de Seguridad')!!}</li>
                            @else
                                <li>{!!link_to('miPerfil', 'Mi perfil')!!}</li>
                            @endif
                                <li role="separator" class="divider"></li>
                            <li><a class="" href="{{ url('/auth/logout') }}">Salir</a></li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown">
                        <a class="dropdown-toggle login" href="login" data-toggle="dropdown">Entrar<strong
                                    class="caret"></strong></a>

                        <div class="dropdown-menu" style="padding: 20px">
                            {!! FORM::open(array('url' => 'auth/login')) !!}
                            {!! FORM::label('email', 'email') !!} <br/>
                            {!! FORM::text ('email','',array("placeholder"=>"email de usuario",
                            "class"=>"form-control")) !!}
                            <br/>
                            {!! FORM::label ('password', 'contraseña') !!} <br/>
                            {!! FORM::password ('password',array("class"=>"form-control","placeholder"=>"password"))
                            !!} <br/>
                            {!! FORM::submit('Entrar',array("class"=>"btn btn-success btn-block")) !!}
                            <br/>
                            <a class="formularioModal btn btn-default btn-block" href="">Registrarse</a>
                            {!! FORM::close() !!}
                        </div>
                    </li>
                @endif
            </ul>
        </div>
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
@yield ('titulo')
@yield("contenido")
<footer>
    <span>&copy; Palencia | KOALNET - 2015 | v1.0.0</span>
</footer>
{!! HTML::script('js/jquery-2.1.1.js') !!}
{!! HTML::script('js/bootstrap.min.js') !!}
{!! HTML::script("js/comun/spinner.js")!!}
@yield("js")
</body>
</html>
