@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            <div class="row ">
                @include('tiposParticipantes.parciales.buscar')
            </div>
            @if(!$tipos_participantes->isEmpty())

                <div class="full-Width">
                    <table class="table-viaoptima table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">
                                Tipos de participantes
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tipos_participantes as $tipo_participante)
                            <tr>
                                <td>{{ $tipo_participante->participante }}</td>
                                <td class="table-autenticado-columna-1 text-right">
                                    <div class="btn-action">
                                        <a title="Editar" href="{{route('tiposParticipantes.edit', $tipo_participante->id)}}"
                                           class="pull-left">
                                            <i class="glyphicon glyphicon-edit">
                                                <div>Editar</div>
                                            </i>
                                        </a>
                                        @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                            {!! FORM::open(array('route' => array('tiposParticipantes.destroy', $tipo_participante->id),
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
                    @else
                        <div class="clearfix">
                            <div class="alert alert-info" role="alert">
                                <p><strong>¡Aviso!</strong> No se ha encontrado ningun tipo de participante que listar.</p>
                            </div>
                        </div>
                    @endif
                    <div class="row text-center">
                        {!! $tipos_participantes->appends(Request::only(['participante']))->render()
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