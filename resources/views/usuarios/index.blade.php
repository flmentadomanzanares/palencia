@extends ("plantillas.admin")

@section ("titulo")
    <h1 class="text-center">{!! $titulo !!}</h1>
@stop
@section ("contenido")
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'usuarios.parciales.buscar'])
                @include('comun.plantillaOperacionesIndex',['tabla'=>'usuarios'])
            @endif
            @if(!$users->isEmpty())
                @foreach ($users as $usuario)
                    <table class="table-viaoptima table-striped">
                        <caption>
                            <img src="{!! asset('uploads/usuarios/'.$usuario->foto) !!}" alt=""/>

                            <div class="pull-left @if(!$usuario->activo) foreground-disabled @endif ">
                                {!! $usuario->fullname!!}
                            </div>
                        </caption>
                        <thead>
                        <tr @if(!$usuario->activo) class="background-disabled" @endif>
                            <th colspan="2" class="text-right">
                                <a title="Editar"
                                   href="{{route('usuarios.edit',array('id'=>$usuario->id))}}">
                                    <i class="glyphicon glyphicon-edit">
                                        <div>Editar</div>
                                    </i>
                                </a>
                                @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                    @if($usuario->activo)
                                        {!! FORM::open(array('route' => array('usuarios.destroy',
                                        $usuario->id),'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar'))) !!}
                                        <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                                @if(config('opciones.accion.mostrarModalDeBorrado'))
                                                class="pull-right lanzarModal simpleModal"
                                                data-modal_centro_pantalla="true"
                                                data-modal_en_la_derecha="false"
                                                data-modal_sin_etiqueta="true"
                                                data-modal_ancho="330"
                                                data-modal_cabecera_color_fondo='rgba(255,0,0,.9)'
                                                data-modal_cabecera_color_texto='#ffffff'
                                                data-modal_cuerpo_color_fondo='rgba(255,255,255,1)'
                                                data-modal_cuerpo_color_texto='"#ffffff'
                                                data-modal_pie_color_fondo='#400090'
                                                data-modal_pie_color_texto='"#ffffff'
                                                data-modal_posicion_vertical="220"
                                                data-titulo="BORRAR"
                                                data-pie="true"
                                                data-descripcion="¿Seguro que deseas eliminar este usuario?
                                                    <h3><strong class='green'>{{ $usuario->fullname}}</strong></h3>"
                                                @endif >
                                            <i class='glyphicon glyphicon-trash full-Width'>
                                                <div>Borrar</div>
                                            </i>
                                        </button>
                                        @if(config('opciones.accion.mostrarModalDeBorrado'))
                                            @include ("comun.plantillaBorrado")
                                        @endif
                                        {!! FORM::close() !!}
                                    @endif
                                @endif
                            </th>
                        </tr>
                        </thead>
                        <tbody @if(!$usuario->activo) class="foreground-disabled" @endif>
                        <tr>
                            <td class="table-autenticado-columna-1">Usuario:</td>
                            <td>{!! $usuario->name !!}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{!! $usuario->email !!}</td>
                        </tr>
                        <tr>
                            <td>Rol</td>
                            <td>{!! ($usuario->roles->rol )!!}</td>
                        </tr>

                        @if (Auth::check())
                            @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                <tr>
                                    <td>Activo</td>
                                    <td>{!! $usuario->activo?'Si':'No' !!}</td>
                                </tr>
                                <tr>
                                    <td>Confirmado</td>
                                    <td>{!! $usuario->confirmado?'Si':'No' !!}</td>
                                </tr>
                            @endif
                        @endif
                        <tr>
                            <td>Fecha Alta</td>
                            <td>{!! date("d/m/Y H:i:s",strtotime($usuario->created_at)) !!}</td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                @if (Auth::user()->roles->peso<config('opciones.roles.administrador'))
                    <div class="btn-action">
                        <a title="Volver" href="{{route('inicio')}}" class="pull-right">
                            <i class="glyphicon glyphicon-home">
                                <div>Inicio</div>
                            </i>
                        </a>
                    </div>
                @endif
                {!! $users->appends(Request::only(['campo','value','rol']))->render()!!}
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ning&uacute;n usuario que listar.</p>
                    </div>
                </div>
            @endif

        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
