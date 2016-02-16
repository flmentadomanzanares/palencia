@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @include('roles.parciales.buscar')
            </div>
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
                                {!! FORM::open(array('route' => array('roles.destroy',
                                $rol->id),'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar'))) !!}
                                <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                        @if(config('opciones.accion.mostrarModalDeBorrado'))
                                        class="pull-right lanzarModal"
                                        data-title="BORRADO"
                                        data-descripcion="¿Seguro que deseas eliminar este rol?
                                                    <h3><strong class='green'>{{ $rol->rol}}</strong></h3>"
                                        data-footer="true"
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
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun rol que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row paginationBlock">
                {!! $roles->appends(Request::only(['rol']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
