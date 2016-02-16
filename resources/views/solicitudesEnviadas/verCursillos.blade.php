@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())

            @if(!$solicitudesEnviadasCursillos->isEmpty())
                <div class="heading-caption-bold" style="background-color:{{$comunidad->color}};">
                    Solicitud: {{ $solicitudId }} - Comunidad: {{ $comunidad->comunidad }}
                </div>
                @foreach ($solicitudesEnviadasCursillos as $solicitudEnviadaCursillos)
                    <div>
                        <table class="table-viaoptima table-striped">

                            <thead>
                            <tr style="background-color:{{$comunidad->color}};">
                                <th colspan="2">
                                    {!! $solicitudEnviadaCursillos->cursillo !!}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="table-autenticado-columna-1">Número:</td>
                                <td>
                                    {!!$solicitudEnviadaCursillos->num_cursillo!!}
                                </td>
                            </tr>
                            <tr>
                                <td>Año ISO-8601:</td>
                                <td>{!! Date("o" , strtotime($solicitudEnviadaCursillos->fecha_inicio) )!!}</td>
                            </tr>
                            <tr>
                                <td>Semana ISO-8601:</td>
                                <td>{!! Date("W" , strtotime($solicitudEnviadaCursillos->fecha_inicio) )!!}</td>
                            </tr>
                            <tr>
                                <td>Asistentes:</td>
                                <td>{!!$solicitudEnviadaCursillos->tipo_participante!!}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
                <div class="panel-search">
                    <a title="Volver" href="{{route('solicitudesEnviadas.index')}}" class="pull-left">
                        <i class="glyphicon glyphicon-arrow-left">
                            <div>Volver</div>
                        </i>
                    </a>
                </div>
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun cursillo que listar.</p>
                    </div>
                </div>
            @endif
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection