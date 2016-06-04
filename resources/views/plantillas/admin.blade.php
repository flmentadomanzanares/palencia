<!DOCTYPE html>
<html lang="es">
<head>
    <title>Palencia</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    {!! HTML::style('css/palencia.css') !!}
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
                            <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Administrador<span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>{!!link_to('paises', 'Países')!!}</li>
                                <li>{!!link_to('provincias', 'Provincias')!!}</li>
                                <li>{!!link_to('localidades', 'Localidades')!!}</li>
                                <li>{!!link_to('comunidades', 'Comunidades')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('cursillos', 'Cursillos')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('nuestrasSolicitudes', 'Nuestras Solicitudes')!!}</li>
                                <li>{!!link_to('solicitudesEnviadas', 'Sus Respuestas')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('solicitudesRecibidas', 'Consultar sus Solicitudes')!!}</li>
                                <li>{!!link_to('nuestrasRespuestas', 'Responder')!!}</li>
                                <li role="separator" class="divider"></li>
                                <li>{!!link_to('tiposSecretariados', 'Tipos Secretariados')!!}</li>
                                @if (config("opciones.accion.roles"))
                                    <li>{!!link_to('roles', 'Roles')!!}</li>
                                @endif
                                @if (config("opciones.accion.tiposParticipantes"))
                                    <li>{!!link_to('tiposParticipantes', 'Tipo de Participantes')!!}</li>
                                @endif
                                @if (config("opciones.accion.tipoComunicacionesPreferidas"))
                                    <li>{!!link_to('tiposComunicacionesPreferidas', 'Tipo de Comunicación')!!}</li>
                                @endif
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">Listados<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li>{!!link_to('cursillosPaises', 'Cursillos en el mundo')!!}</li>
                                <li>{!!link_to('intendenciaClausura', 'Intendencia para clausura')!!}</li>
                                <li>{!!link_to('secretariado', 'Secretariado')!!}</li>
                                <li>{!!link_to('secretariadosPais', 'Secretariados activos por pais')!!}</li>
                                <li>{!!link_to('secretariadosPaisInactivos', 'Secretariados inactivos por pais')!!}</li>
                                <li>{!!link_to('noColaboradores', 'Secretariados activos no colaboradores')!!}</li>
                                <li>{!!link_to('noColaboradoresInactivos', 'Secretariados inactivos no colaboradores')!!}</li>
                                <li>{!!link_to('imprimirPaisesActivos', 'Paises activos')!!}</li>

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
                                @if (config("opciones.accion.copiaSeguridad"))
                                    <li role="separator" class="divider"></li>
                                    <li>{!!link_to('copiaSeguridad','Copia de Seguridad')!!}</li>
                                @endif
                                @if (config("opciones.accion.cerrarAnyo"))
                                    <li role="separator" class="divider"></li>
                                    <li>{!!link_to('cerrarAnyo','Cerrar A&ntilde;o')!!}</li>
                                @endif
                            @else
                                <li>{!!link_to('miPerfil', 'Mi perfil')!!}</li>
                            @endif
                            <li role="separator" class="divider"></li>
                            <li><a class="" href="{{ url('/auth/logout') }}">Salir</a></li>
                        </ul>
                    </li>
                @else
                    @if(config("opciones.seguridad.recordarPassword"))
                        @include ("comun.plantillaRecordarPassword")
                    @endif
                    @include ("comun.plantillaRegistro")
                    <li class="dropdown">
                        <a class="dropdown-toggle login" href="login" data-toggle="dropdown">Entrar<strong
                                    class="caret"></strong></a>

                        <div class="dropdown-menu" style="padding: 20px">
                            {!! FORM::open(array('url' => 'auth/login')) !!}
                            {!! FORM::label('email', 'email') !!}
                            {!! FORM::text ('email','',array("placeholder"=>"email de usuario",
                            "class"=>"form-control")) !!}
                            {!! FORM::label ('password', 'contraseña') !!}
                            {!! FORM::password ('password',array("class"=>"form-control","placeholder"=>"password"))
                            !!}
                            {!! FORM::submit('Entrar',array("class"=>"btn btn-success btn-block")) !!}
                            @if(config("opciones.seguridad.recordarPassword"))
                                <br/>
                                <span class="btn btn-default btn-block lanzarModal simpleModal" data-title="RECORDAR"
                                      data-selector-Id="recordar"
                                      data-modal_sin_etiqueta="true"
                                      data-modal_ancho="330"
                                      data-modal_cabecera_color_fondo='rgba(255,125,0,.9)'
                                      data-modal_cabecera_color_texto='#ffffff'
                                      data-modal_cuerpo_color_fondo='rgba(255,255,255,.9)'
                                      data-modal_cuerpo_color_texto='"#ffffff'
                                      data-modal_posicion_vertical="115"
                                      data-titulo="PASSWORD">Recordar password</span>
                            @endif
                            <br/>
                            <span class="btn btn-default btn-block lanzarModal simpleModal" data-title="REGISTRO"
                                  data-selector-Id="registro"
                                  data-modal_sin_etiqueta="true"
                                  data-modal_ancho="330"
                                  data-modal_cabecera_color_fondo='rgba(255,125,0,.9)'
                                  data-modal_cabecera_color_texto='#ffffff'
                                  data-modal_cuerpo_color_fondo='rgba(255,255,255,.9)'
                                  data-modal_cuerpo_color_texto='"#ffffff'
                                  data-modal_posicion_vertical="115"
                                  data-titulo="REGISTRO">Registrarse</span>
                            {!! FORM::close() !!}
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>

@if(Session::has('mensaje'))
    <div class="alert-dismissible">
        <div class="errorOnBackGround"></div>
        <div class="alert alert-info errorOn" role="alert">
            <div class="closeErrorModal pull-right">X</div>
            <strong>¡Aviso!</strong> {!! Session::get('mensaje') !!}
        </div>
    </div>
@endif
@if($errors->has())
    <div id="errores" class="alert-dismissible">
        <div class="errorOnBackGround"></div>
        <div class="alert alert-danger errorOn" role="alert">
            <div class="closeErrorModal pull-right">X</div>
            <strong>Errores</strong>
            <ol>
                @foreach ($errors->all('<p>:message</p>') as $message)
                    <li>{!! $message !!}</li>
                @endforeach
            </ol>
        </div>
    </div>
@endif
@yield ('titulo')
@yield("contenido")
<footer>
    <span>&copy; Palencia v2.0.0 | KOALNET - 2015</span>
</footer>
{!! HTML::script('js/jquery-2.1.1.js') !!}
{!! HTML::script('js/bootstrap.min.js') !!}
{!! HTML::script("js/comun/spinner.js")!!}
{!! HTML::script('js/publico/simplemodal.js') !!}
{!! HTML::script("js/comun/modales.js")!!}
@yield("js")
</body>
</html>
