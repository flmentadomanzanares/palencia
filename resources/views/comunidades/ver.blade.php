@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        <table class="table-viaoptima table-striped">
            <thead>
            <tr style="@if($comunidad->activo==0)background: red !important; @endif">
                <th colspan="2" class="text-center">
                    {!! $comunidad->comunidad !!}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="table-autenticado-columna-1">Secretariado</td>
                <td>{{ $comunidad->tipo_secretariado }}</td>
            </tr>
            <tr>
                <td>Es Popia:</td>
                <td> @if ($comunidad->esPropia) Si @else No @endif </td>
            </tr>
            <tr>
                <td>Responsable</td>
                <td> {!! $comunidad->responsable !!}</td>
            </tr>
            <tr>
                <td>Pais</td>
                <td> {{ $comunidad->pais }} </td>
            </tr>
            <tr>
                <td>Provincia</td>
                <td> {{ $comunidad->provincia}} </td>
            </tr>
            <tr>
                <td>Localidad</td>
                <td>{{ $comunidad->localidad }}</td>
            </tr>
            <tr>
                <td>Código Postal</td>
                <td>{{ $comunidad->cp }}</td>
            </tr>
            <tr>
                <td>Dirección Postal</td>
                <td>{{ $comunidad->direccion_postal }}</td>
            </tr>
            <tr>
                <td>Dirección</td>
                <td>{{ $comunidad->direccion }}</td>
            </tr>
            <tr>
                <td>Email Solicitud</td>
                <td>{{ $comunidad->email_solicitud }}</td>
            </tr>
            <tr>
                <td>Email Envío</td>
                <td>{{ $comunidad->email_envio }}</td>
            </tr>
            <tr>
                <td>WEB</td>
                <td>{{ $comunidad->web }}</td>
            </tr>
            <tr>
                <td>Facebook</td>
                <td>{{ $comunidad->facebook }}</td>
            </tr>
            <tr>
                <td>Teléfono 1</td>
                <td>{{ $comunidad->telefono1 }}</td>
            </tr>
            <tr>
                <td>Teléfono 2</td>
                <td>{{ $comunidad->telefono2 }}</td>
            </tr>
            <tr>
                <td>Comunicación Preferida</td>
                <td>{{ $comunidad->comunicacion_preferida }}</td>
            </tr>
            <tr>
                <td>Observaciones</td>
                <td>{{ $comunidad->observaciones }}</td>
            </tr>
            <tr>
                <td>Colabora:</td>
                <td> @if ($comunidad->esColaborador) Si @else No @endif </td>
            </tr>
            <tr>
                <td>Color Cursos:</td>
                <td> <div class="ponerCirculoColor" style="background-color:{{$comunidad->color}}"></div></td>
            </tr>
            <tr>
                <td>Activo</td>
                <td>@if ($comunidad->activo == 0)No @else Si @endif</td>
            </tr>
            </tbody>
        </table>
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{URL::previous()}}" class="pull-right">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
        </div>
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection