@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @include('tiposComunicacionesPreferidas.parciales.buscar')
            </div>
            @if(!$tipos_comunicaciones_preferidas->isEmpty())
                <div class="full-Width">
                    <table class="table-viaoptima table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">Comunicaciones preferidas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tipos_comunicaciones_preferidas as $tipo_comunicacion)
                            <tr @if(!$tipo_comunicacion->activo) class="foreground-disabled" @endif>
                                <td>{{ $tipo_comunicacion->comunicacion_preferida }}</td>
                                <td class="table-autenticado-columna-1 text-right">
                                    <div class="btn-action">
                                        <a title="Editar"
                                           href="{{route('tiposComunicacionesPreferidas.edit', $tipo_comunicacion->id)}}"
                                           class="pull-left">
                                            <i class="glyphicon glyphicon-edit">
                                                <div>Editar</div>
                                            </i>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            {!! FORM::open(array('route' => array('tiposComunicacionesPreferidas.destroy', $tipo_comunicacion->id),
                                            'method' => 'DELETE','title'=>'Borrar')) !!}
                                            <button type="submit" class="pull-right">
                                                <i class='glyphicon glyphicon-trash full-Width'>
                                                    <div>Borrar</div>
                                                </i>
                                            </button>
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
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun tipo de comunicacion preferida que
                            listar.</p>
                    </div>
                </div>
            @endif
            <div class="row paginationBlock">
                {!! $tipos_comunicaciones_preferidas->appends(Request::only(['comunicacion_preferida']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection