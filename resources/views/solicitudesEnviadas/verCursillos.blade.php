@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())

            @if(!$solicitudesEnviadasCursillos->isEmpty())
                <div class="full-Width">
                    <table class="table-viaoptima table-striped">
                        <thead>
                        <tr>
                            <th colspan="2">
                                Solicitud: {{ $solicitudId }} - Comunidad: {{ $comunidad->comunidad }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($solicitudesEnviadasCursillos as $solicitudEnviadaCursillo)
                            <tr>
                                <td>{{ $solicitudEnviadaCursillo->cursillo }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="btn-action margin-bottom">
                        <a title="Volver" href="{{URL::previous()}}" class="pull-right">
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