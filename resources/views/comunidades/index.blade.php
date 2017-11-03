@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'comunidades.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'comunidades','accion'=>'Nueva'])
            @if(!$comunidades->isEmpty())
                @foreach ($comunidades as $comunidad)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <thead>
                            <tr class="row-fixed">
                                <th class="tabla-ancho-columna-texto"></th>
                                <th></th>
                            </tr>
                            <tr @if(!$comunidad->activo) class="background-disabled" @endif>
                                <th colspan="2" class="text-right">
                                    <a title="Mostrar"
                                       href="{{route('comunidades.show',$comunidad->id)}}">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                        <div>Detalles</div>
                                    </a>
                                    <a title="Editar"
                                       href="{{route('comunidades.edit',$comunidad->id)}}">
                                        <i class="glyphicon glyphicon-edit"></i>
                                        <div>Editar</div>
                                    </a>
                                    @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                    @if($comunidad->activo)
                                        {!! FORM::open(array('route' => array('comunidades.destroy',
                                        $comunidad->id),'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar')))!!}
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
                                                data-descripcion="¿Seguro que deseas eliminar esta comunidad?<br><h3><strong>{{$comunidad->comunidad}}</strong></h3>"
                                                data-footer="true"
                                                @endif >
                                            <i class='glyphicon glyphicon-trash full-Width'></i>
                                            <div>Borrar</div>
                                        </button>
                                        @if(config('opciones.accion.mostrarModalDeBorrado'))
                                            @include ("comun.plantillaBorrado")
                                        @endif
                                        {!! FORM::close() !!}
                                    @endif
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="cabecera">
                                    <div class="ellipsis text-center @if(!$comunidad->activo) foreground-disabled @endif"
                                         @if($comunidad->activo==1) style="background-color:
                                         {{$comunidad->colorFondo}} !important; color:{{$comunidad->colorTexto}} !important; @endif ">
                                        {!! $comunidad->comunidad !!}
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody @if(!$comunidad->activo) class="foreground-disabled" @endif>
                            <tr>
                                <td>Secretariado:</td>
                                <td>
                                    {!! $comunidad->tipo_secretariado !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Es Propia:</td>
                                <td> @if ($comunidad->esPropia) Si @else No @endif </td>
                            </tr>
                            <tr>
                                <td>Pa&iacute;s:</td>
                                <td>
                                    {!! $comunidad->pais !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Provincia:</td>
                                <td>
                                    {!! $comunidad->provincia !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Localidad:</td>
                                <td>
                                    {!! $comunidad->localidad !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Responsable:</td>
                                <td>
                                    {!! $comunidad->responsable !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Direcci&oacute;n:</td>
                                <td>
                                    {!! $comunidad->direccion !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Comunicaci&oacute;n preferida:</td>
                                <td>{{strcasecmp($comunidad->comunicacion_preferida,"carta")==0 ? $comunidad->comunicacion_preferida : $comunidad->email_envio}}</td>
                            </tr>
                            <tr>
                                <td>Colabora:</td>
                                <td> @if ($comunidad->esColaborador) Si @else No @endif </td>
                            </tr>
                            <tr>
                                <td>Activo:</td>
                                <td> @if ($comunidad->activo) Si @else No @endif </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
                {!! $comunidades->appends(Request::only(['comunidad','esPropia','pais','esActivo']))->render()!!}
            @else
                <div class="">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ninguna comunidad que listar.</p>
                    </div>
                </div>
            @endif
        @else
            @include('invitado')
        @endif
    </div>
@endsection
@section('js')
@endsection
