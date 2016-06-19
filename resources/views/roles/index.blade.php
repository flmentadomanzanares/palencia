@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'roles.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'roles','accion'=>'Nuevo'])
            @if(!$roles->isEmpty())
                @foreach ($roles as $rol)
                    <table class="table-viaoptima table-striped">
                        <caption class="@if(!$rol->activo) foreground-disabled @endif">
                            {!! $rol->rol !!}
                        </caption>
                        <thead>
                        <tr @if(!$rol->activo) class="background-disabled" @endif>
                            <th colspan="2" class="text-right">
                                <a title="Editar"
                                   href="{{route('roles.edit',array('id'=>$rol->id))}}">
                                    <i class="glyphicon glyphicon-edit">
                                        <div>Editar</div>
                                    </i>
                                </a>
                                @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                @if($rol->activo)
                                    {!! FORM::open(array('route' => array('roles.destroy',
                                    $rol->id),'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar'))) !!}
                                    <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                            @if(config('opciones.accion.mostrarModalDeBorrado'))
                                            class="pull-right lanzarModal simpleModal"
                                            data-modal_sin_etiqueta="true"
                                            data-modal_ancho="330"
                                            data-modal_cabecera_color_fondo='rgba(255,0,0,.9)'
                                            data-modal_cabecera_color_texto='#ffffff'
                                            data-modal_cuerpo_color_fondo='rgba(255,255,255,.9)'
                                            data-modal_cuerpo_color_texto='"#ffffff'
                                            data-modal_pie_color_fondo='#400090'
                                            data-modal_pie_color_texto='"#ffffff'
                                            data-modal_posicion_vertical="220"
                                            data-titulo="BORRAR"
                                            data-pie="true"
                                            data-descripcion="¿Seguro que deseas eliminar este rol?
                                                        <h3><strong class='green'>{{ $rol->rol}}</strong></h3>"
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
                        <tbody @if(!$rol->activo) class="foreground-disabled" @endif>
                        <tr>
                            <td class="table-autenticado-columna-1">Peso:</td>
                            <td>{!! ($rol->peso )!!}</td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ning&uacute;n rol que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row paginationBlock">
                {!! $roles->appends(Request::only(['rol','esActivo']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
