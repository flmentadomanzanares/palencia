@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'provincias.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'provincias','accion'=>'Nueva'])
            @if(!$provincias->isEmpty())
                <div class="full-Width">
                    @foreach ($provincias as $provincia)
                        <table class="table-viaoptima table-striped pull-left">
                            <thead>
                            <tr @if(!$provincia->activo) class="background-disabled" @endif>
                                <th colspan="2" class="text-left">
                                    {{$provincia->paises->pais}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td @if(!$provincia->activo) class="foreground-disabled" @endif>{{ $provincia->provincia }}</td>
                                <td class="table-autenticado-columna-1 text-right">
                                    <div class="btn-action">
                                        <a title="Editar" href="{{route('provincias.edit', $provincia->id)}}"
                                           class="@if($provincia->activo) pull-left @else pull-right @endif">
                                            <i class="glyphicon glyphicon-edit">
                                                <div>Editar</div>
                                            </i>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            @if($provincia->activo)
                                                {!! FORM::open(array('route' => array('provincias.destroy', $provincia->id),
                                                'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar'))) !!}
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
                                                        data-descripcion="¿Seguro que deseas eliminar esta provincia?
                                                        <h3><strong class='green'>{{$provincia->provincia}}</strong></h3>"
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
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
                {!! $provincias->appends(Request::only(['provincia','esActivo']))->render()!!}
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ninguna provincia que
                            listar.</p>
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