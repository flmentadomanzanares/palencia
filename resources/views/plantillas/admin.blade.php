<!DOCTYPE html>
<html lang="es">
<head>
    <title>Palencia</title>
    <meta charset="UTF-8">
    <meta name=description content=" oraciones">
    <link rel="shortcut icon" href="{{ url('img/iconos/favicon.ico')}}" type="image/x-icon"/>
    <meta name=viewport content="width=320, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    {!! HTML::style('css/palencia.css') !!}
    @yield("css")
</head>
<body>


<div class="row img-header">
    <div></div>
</div>
<div data-role="menu">
    @if (Auth::check())
        <ul>
            <li><a href="{{ url('inicio') }}"><span class="glyphicon glyphicon-home"></span></a></li>
            @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                @if (config("opciones.listados.mostrarListados"))
                <li>
                    <span class="p-h-10">Listados<span class="caret"></span></span>
                    <ul>
                        @if (config("opciones.listados.cursillosPaises"))
                            <li>{!!link_to('cursillosPaises', 'Cursillos en el mundo')!!}</li>
                        @endif
                        @if (config("opciones.listados.intendenciaClausura"))
                            <li>{!!link_to('intendenciaClausura', 'Intendencia para clausura')!!}</li>
                        @endif
                        @if (config("opciones.listados.secretariado"))
                            <li>{!!link_to('secretariado', 'Secretariado')!!}</li>
                        @endif
                        @if (config("opciones.listados.secretariadosPais"))
                            <li>{!!link_to('secretariadosPais', 'Secretariados activos por pa&iacute;s')!!}</li>
                        @endif
                        @if (config("opciones.listados.secretariadosPaisInactivos"))
                            <li>{!!link_to('secretariadosPaisInactivos', 'Secretariados inactivos por pa&iacute;s')!!}</li>
                        @endif
                        @if (config("opciones.listados.noColaboradores"))
                            <li>{!!link_to('noColaboradores', 'Secretariados activos no colaboradores')!!}</li>
                        @endif
                        @if (config("opciones.listados.noColaboradoresInactivos"))
                            <li>{!!link_to('noColaboradoresInactivos', 'Secretariados inactivos no colaboradores')!!}</li>
                        @endif
                        @if (config("opciones.listados.imprimirPaisesActivos"))
                            <li>{!!link_to('imprimirPaisesActivos', 'Pa&iacute;ses activos')!!}</li>
                        @endif
                        @if (config("opciones.listados.secretariadosColaboradoresSinResponder"))
                            <li>{!!link_to('secretariadosColaboradoresSinResponder', 'Secretariados colaboradores sin responder')!!}</li>
                        @endif
                    </ul>
                </li>
                @endif
                <li><span class="p-h-10">Administrador<span class="caret"></span></span>
                    <ul>
                        <li>{!!link_to('paises', 'Pa&iacute;ses')!!}</li>
                        <li>{!!link_to('provincias', 'Provincias')!!}</li>
                        <li>{!!link_to('localidades', 'Localidades')!!}</li>
                        <li>{!!link_to('comunidades', 'Comunidades')!!}</li>
                        <li class="menu-separator"></li>
                        <li>{!!link_to('cursillos', 'Cursillos')!!}</li>
                        <li class="menu-separator"></li>
                        <li>{!!link_to('nuestrasSolicitudes', 'Nuestras Solicitudes')!!}</li>
                        <li>{!!link_to('solicitudesEnviadas', 'Sus Respuestas')!!}</li>
                        <li>{!!link_to('respuestasSinSolicitudes', 'Respuesta sin nuestra Solicitud')!!}</li>
                        <li class="menu-separator"></li>
                        <li>{!!link_to('solicitudesRecibidas', 'Consultar sus Solicitudes')!!}</li>
                        <li>{!!link_to('nuestrasRespuestas', 'Responder')!!}</li>
                        <li class="menu-separator"></li>
                        <li>{!!link_to('tiposSecretariados', 'Tipos de Secretariados')!!}</li>
                        @if (config("opciones.accion.tiposParticipantes"))
                            <li>{!!link_to('tiposParticipantes', 'Tipos de Participantes')!!}</li>
                        @endif
                        @if (config("opciones.accion.tipoComunicacionesPreferidas"))
                            <li>{!!link_to('tiposComunicacionesPreferidas', 'Tipos de Comunicaci&oacute;n')!!}</li>
                        @endif
                    </ul>
                </li>
            @endif
            <li class="pull-right">
                <span class="p-h-10"><img
                            class="user-image"
                            src=" {!!asset('uploads/usuarios/'.Auth::user()->foto) !!}">
                    <span class="hidden-xxs">{!!Auth::user()->name!!}
                        <b class="caret"></b>
                        </span>
                </span>
                <ul class="right">
                    @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                        <li>{!!link_to('usuarios', 'Usuarios')!!}</li>
                        @if (config("opciones.accion.roles"))
                            <li>{!!link_to('roles', 'Roles')!!}</li>
                        @endif
                        @if (config("opciones.accion.copiaSeguridad"))
                            <li class="menu-separator"></li>
                            <li>{!!link_to('copiaSeguridad','Copia de Seguridad')!!}</li>
                        @endif
                        @if (config("opciones.accion.cerrarAnyo"))
                            <li class="menu-separator"></li>
                            <li>{!!link_to('cerrarAnyo','Cerrar A&ntilde;o')!!}</li>
                        @endif
                    @else
                        <li>{!!link_to('miPerfil', 'Mi perfil')!!}</li>
                    @endif
                    <li class="menu-separator"></li>
                    <li><a class="" href="{{ url('/auth/logout') }}">Salir</a></li>
                </ul>
            </li>
        </ul>
        <div class="ActionBlockLeft">
            <div class="hideShowSimpleModal hidden-md hidden-lg">
                <i class="knt-mt-icons"></i>
            </div>
            <div class="scroll_to_bottom">
                <i class="knt-mt-icons">&#xE5C5;</i>
            </div>
        </div>
        <div class="scroll_to_top">
            <i class="knt-mt-icons">&#xE5C7;</i>
        </div>
    @else
        @include ("comun.plantillaLogin")
        @if (config("opciones.incluirModalAltas"))
            @include('comun.plantillaRegistrarse')
        @endif
        @if(config("opciones.seguridad.recordarPassword"))
            @include ("comun.plantillaRecordarPassword")
        @endif
    @endif
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
    <span>&copy; Palencia v2.5.0 | KOALNET - {!! date("Y") !!}</span>
</footer>
{!! HTML::script('js/jquery-2.1.1.js') !!}
{!! HTML::script('js/bootstrap.min.js') !!}
{!! HTML::script("js/comun/spinner.js")!!}
{!! HTML::script('js/publico/simplemodal.js') !!}
{!! HTML::script('js/publico/menu.js') !!}
{!! HTML::script('js/publico/scroll_to_top.js') !!}
{!! HTML::script('js/publico/functions.js') !!}
@yield("js")
</body>
</html>
