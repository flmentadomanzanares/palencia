@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'paises.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'paises','accion'=>'Nuevo'])
            @if(!$paises->isEmpty())

                <table class="table-viaoptima table-striped">
                        <thead>
                        <tr class="row-fixed">
                            <th></th>
                            <th class="tabla-ancho-columna-botones"></th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                Pa&iacute;ses
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($paises as $pais)
                            <tr @if(!$pais->activo) class="foreground-disabled" @endif>
                                <td>{{ $pais->pais }}</td>
                                <td class="padding-right">
                                    <div class="btn-action">
                                        <a title="Editar" href="{{route('paises.edit', $pais->id)}}"
                                           class="@if($pais->activo) pull-left @else pull-right @endif">
                                            <i class="glyphicon glyphicon-edit"></i>
                                            <div>Editar</div>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            @if($pais->activo)
                                                {!! FORM::open(array('route' => array('paises.destroy', $pais->id),
                                                'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar')))  !!}
                                                <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                                        @if(config('opciones.accion.mostrarModalDeBorrado'))
                                                        class="pull-right simpleModal"
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
                                                        data-descripcion="¿Seguro que deseas eliminar este pa&iacute;s?
                                                        <h3><strong class='green'>{{$pais->pais}}</strong></h3>"
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                {!! $paises->appends(Request::only(['pais','esActivo']))->render()!!}
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ning&uacute;n pa&iacute;s que listar.</p>
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