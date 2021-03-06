@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        <table class="table-viaoptima table-striped">
            <thead>
            <tr class="row-fixed">
                <th class="tabla-ancho-columna-texto"></th>
                <th></th>
            </tr>
            <tr style="background-color:@if($comunidad->activo==0)red !important;
            @else{{$comunidad->colorFondo}} !important; @endif
            @if($comunidad->activo==1)
                    color:{{$comunidad->color}} !important;
            @endif">
                <th colspan="2" class="text-center">
                    {!! $comunidad->comunidad !!}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Secretariado:</td>
                <td>{{ $comunidad->tipo_secretariado }}</td>
            </tr>
            <tr>
                <td>Es Popia:</td>
                <td> @if ($comunidad->esPropia) Si @else No @endif </td>
            </tr>
            <tr>
                <td>Responsable:</td>
                <td> {!! $comunidad->responsable !!}</td>
            </tr>
            <tr>
                <td>Pais:</td>
                <td> {{ $comunidad->pais }} </td>
            </tr>
            <tr>
                <td>Provincia:</td>
                <td> {{ $comunidad->provincia}} </td>
            </tr>
            <tr>
                <td>Localidad:</td>
                <td>{{ $comunidad->localidad }}</td>
            </tr>
            <tr>
                <td>C&oacute;digo Postal:</td>
                <td>{{ $comunidad->cp }}</td>
            </tr>
            <tr>
                <td>Direcci&oacute;n Postal:</td>
                <td>{{ $comunidad->direccion_postal }}</td>
            </tr>
            <tr>
                <td>Direcci&oacute;n:</td>
                <td>{{ $comunidad->direccion }}</td>
            </tr>
            <tr>
                <td>Email Solicitud:</td>
                <td>{{ $comunidad->email_solicitud }}</td>
            </tr>
            <tr>
                <td>Email Env&iacute;o:</td>
                <td>{{ $comunidad->email_envio }}</td>
            </tr>
            <tr>
                <td>WEB:</td>
                <td>{{ $comunidad->web }}</td>
            </tr>
            <tr>
                <td>Facebook:</td>
                <td>{{ $comunidad->facebook }}</td>
            </tr>
            <tr>
                <td>Tel&eacute;fono 1:</td>
                <td>{{ $comunidad->telefono1 }}</td>
            </tr>
            <tr>
                <td>Tel&eacute;fono 2:</td>
                <td>{{ $comunidad->telefono2 }}</td>
            </tr>
            <tr>
                <td>Comunicaci&oacute;n Preferida:</td>
                <td>{{ $comunidad->comunicacion_preferida }}</td>
            </tr>
            <tr>
                <td>Observaciones:</td>
                <td>{{ $comunidad->observaciones }}</td>
            </tr>
            <tr>
                <td>Colabora:</td>
                <td> @if ($comunidad->esColaborador) Si @else No @endif </td>
            </tr>
            <tr>
                <td>Color Texto Cursos:</td>
                <td>
                    <div class="ponerCirculoColor" style="background-color:{{$comunidad->color}}"></div>
                </td>
            </tr>
            <tr>
                <td>Color Fondo Cursos:</td>
                <td>
                    <div class="ponerCirculoColor" style="background-color:{{$comunidad->colorFondo}}"></div>
                </td>
            </tr>
            <tr>
                <td>Activo:</td>
                <td>@if ($comunidad->activo == 0)No @else Si @endif</td>
            </tr>
            </tbody>
        </table>
        @include('comun.plantillaVolverModificarGuardar',['index'=>"comunidades.index"])
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection