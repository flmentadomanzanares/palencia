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
            @if(!$tiposComunicacionesPreferidas->isEmpty())
                <div class="full-Width">
                    <table class="table-viaoptima table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">Comunicaciones preferidas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tiposComunicacionesPreferidas as $tipoComunicacionPreferida)
                            <tr @if(!$tipoComunicacionPreferida->activo) class="foreground-disabled" @endif>
                                <td>{{ $tipoComunicacionPreferida->comunicacion_preferida }}</td>
                                <td class="table-autenticado-columna-1 text-right">
                                    <div class="btn-action">
                                        <a title="Editar"
                                           href="{{route('tiposComunicacionesPreferidas.edit', $tipoComunicacionPreferida->id)}}"
                                           class="pull-left">
                                            <i class="glyphicon glyphicon-edit">
                                                <div>Editar</div>
                                            </i>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            {!! FORM::open(array('route' => array('tiposComunicacionesPreferidas.destroy', $tipoComunicacionPreferida->id),
                                            'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar')))!!}
                                            <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                                    @if(config('opciones.accion.mostrarModalDeBorrado'))
                                                    class="pull-right lanzarModal"
                                                    data-title="BORRADO"
                                                    data-descripcion="¿Seguro que deseas eliminar este tipo de comunicación preferida?
                                                    <h3><strong class='green'>{{ $tipoComunicacionPreferida->comunicacion_preferida }}</strong></h3>"
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
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun tipo de comunicacion preferida que
                            listar.</p>
                    </div>
                </div>
            @endif
            <div class="row paginationBlock">
                {!! $tiposComunicacionesPreferidas->appends(Request::only(['comunicacion_preferida']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection