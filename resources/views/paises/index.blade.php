@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @include('paises.parciales.buscar')
            </div>
            @if(!$paises->isEmpty())
                <div class="full-Width">
                    <table class="table-viaoptima table-striped">
                        <thead>
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
                                <td class="table-autenticado-columna-1 text-right">
                                    <div class="btn-action">
                                        <a title="Editar" href="{{route('paises.edit', $pais->id)}}"
                                           class="pull-left">
                                            <i class="glyphicon glyphicon-edit">
                                                <div>Editar</div>
                                            </i>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            {!! FORM::open(array('route' => array('paises.destroy', $pais->id),
                                            'method' => 'DELETE','title'=>'Borrar')) !!}
                                            <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                                    class="pull-right verificarBorrado" data-selector="confirmarBorrado"
                                                    data-title="BORRADO"
                                                    data-descripcion="¿ Seguro que deseas eliminar el país <b>{{$pais->pais}}</b> ?">
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
                    @else
                        <div class="clearfix">
                            <div class="alert alert-info" role="alert">
                                <p><strong>¡Aviso!</strong> No se ha encontrado ningun pais que listar.</p>
                            </div>
                        </div>
                    @endif
                    <div class="row paginationBlock">
                        {!! $paises->appends(Request::only(['pais']))->render()
                        !!}{{-- Poner el paginador --}}
                    </div>
                    @else
                        @include('comun.guestGoHome')
                    @endif
                </div>
    </div>
@endsection
@section('js')
@endsection