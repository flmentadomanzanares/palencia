@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'localidades.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'localidades','accion'=>'Nueva'])
            @if(!$localidades->isEmpty())
                @foreach ($localidades as $localidad)
                    <table class="table-viaoptima table-striped">
                        <thead>
                        <tr class="row-fixed">
                            <th class="tabla-ancho-columna-texto"></th>
                            <th></th>
                        </tr>
                        <tr @if(!$localidad->activo) class="background-disabled" @endif>
                            <th colspan="2" class="text-right">
                                <a title="Editar"
                                   href="{{route('localidades.edit',array('id'=>$localidad->id))}}">
                                    <i class="glyphicon glyphicon-edit">
                                        <div>Editar</div>
                                    </i>
                                </a>
                                @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                @if($localidad->activo)
                                    {!! FORM::open(array('route' => array('localidades.destroy',
                                    $localidad->id),'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar')))!!}
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
                                            data-descripcion="¿Seguro que deseas eliminar esta localidad?
                                                <h3><strong class='green'>{{$localidad->localidad}}</strong></h3>"
                                            data-pie="true"
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
                        <tr>
                            <th colspan="2" class="cabecera">
                                <div class="ellipsis text-left @if(!$localidad->activo) foreground-disabled @endif">
                                    {!! $localidad->localidad !!}
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr @if(!$localidad->activo) class="foreground-disabled" @endif>
                            <td>Pa&iacute;s:</td>
                            <td>{{ $localidad->pais }}</td>
                        </tr>
                        <tr @if(!$localidad->activo) class="foreground-disabled" @endif>
                            <td>Provincia:</td>
                            <td>{{ $localidad->provincia }}</td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                {!! $localidades->appends(Request::only(['pais','localidad','provincias','esActivo']))->render()!!}
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ninguna localidad que
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
    @if (Auth::check())
        {!! HTML::script("js/comun/direccion.js")!!}
    @endif
@endsection