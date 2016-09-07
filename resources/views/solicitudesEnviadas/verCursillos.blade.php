@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaVolverModificarGuardar',['index'=>"solicitudesEnviadas.index"])
            @if(!$solicitudesEnviadasCursillos->isEmpty())
                <div class="heading-caption-bold">
                    Solicitud: {{ $solicitudId }} - Comunidad: {{ $comunidad->comunidad }}
                </div>
                @foreach ($solicitudesEnviadasCursillos as $solicitudEnviadaCursillos)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <thead>
                            <tr class="row-fixed">
                                <th class="tabla-ancho-columna-texto"></th>
                                <th></th>
                            </tr>
                            <tr style="background-color:{{$comunidad->colorFondo}} ; color :{{$comunidad->colorTexto}}">
                                <th colspan="2" class="ellipsis">
                                    {!! $solicitudEnviadaCursillos->cursillo !!}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>N&uacute;mero:</td>
                                <td>
                                    {!!$solicitudEnviadaCursillos->num_cursillo!!}
                                </td>
                            </tr>
                            <tr>
                                <td>A&ntilde;o ISO-8601:</td>
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
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ning&uacute;n cursillo que listar.</p>
                    </div>
                </div>
            @endif
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection