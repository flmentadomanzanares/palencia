@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row">
                @include('tiposParticipantes.parciales.buscar')
            </div>
            @if(!$tiposParticipantes->isEmpty())
                <div class="full-Width">
                    <table class="table-viaoptima table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">Tipos de participantes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tiposParticipantes as $tipoParticipante)
                            <tr @if(!$tipoParticipante->activo) class="foreground-disabled" @endif >
                                <td>{{ $tipoParticipante->tipo_participante }}</td>
                                <td class="table-autenticado-columna-1 text-right">
                                    <div class="btn-action">
                                        <a title="Editar"
                                           href="{{route('tiposParticipantes.edit', $tipoParticipante->id)}}"
                                           class="pull-left">
                                            <i class="glyphicon glyphicon-edit">
                                                <div>Editar</div>
                                            </i>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            {!! FORM::open(array('route' => array('tiposParticipantes.destroy', $tipoParticipante->id),
                                            'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar'))) !!}
                                            <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                                    @if(config('opciones.accion.mostrarModalDeBorrado'))
                                                    class="pull-right lanzarModal"
                                                    data-title="BORRADO"
                                                    data-descripcion="¿Seguro que deseas eliminar este tipo de participante?
                                                    <h3><strong class='green'>{{ $tipoParticipante->tipo_participante }}</strong></h3>"
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun tipo de participante que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row paginationBlock">
                {!! $tiposParticipantes->appends(Request::only(['tipo_participante']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection