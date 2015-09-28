@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            <div class="row ">
                @include('provincias.parciales.buscar')
                @if(!$provincias->isEmpty())
                    <div class="full-Width">
                        @foreach ($provincias as $provincia)
                        <table class="table-viaoptima table-striped pull-left">
                            <thead>
                            <tr>
                                <th colspan="2" class="text-left">
                                    {{$provincia->paises->pais}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $provincia->provincia }}</td>
                                    <td  class="table-autenticado-columna-1">
                                        <div class="btn-action">
                                            <a title="Editar" href="{{route('provincias.edit', $provincia->id)}}"
                                               class="pull-left">
                                                <i class="glyphicon glyphicon-edit">
                                                    <div>Editar</div>
                                                </i>
                                            </a>
                                            @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                                {!! FORM::open(array('route' => array('provincias.destroy', $provincia->id),
                                                'method' => 'DELETE','title'=>'Borrar')) !!}
                                                <button type="submit"  class="pull-right">
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
                        @else
                            <div class="clearfix">
                                <div class="alert alert-info" role="alert">
                                    <p><strong>¡Aviso!</strong> No se ha encontrado ninguna provincia que
                                        listar.</p>
                                </div>
                            </div>
                        @endif
                        <div class="row text-center">
                            {!! $provincias->appends(Request::only(['provincia']))->render()
                            !!}{{-- Poner el paginador --}}
                        </div>
                        @else
                            @include('comun.guestGoHome')
                        @endif
                    </div>
            </div>
    </div>
@endsection
@section('js')
@endsection