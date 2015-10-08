@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        <table class="table-viaoptima table-striped">
            <thead>
            <tr>
                <th colspan="2" class="text-center">
                    {!! $cursillos->cursillo !!}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="table-autenticado-columna-1">Comunidad</td>
                <td>{{ $cursillos->comunidades->comunidad }}</td>
            </tr>
            <tr class="table-break-word">
                <td>Descripción</td>
                <td> {!! $cursillos->descripcion !!}</td>
            </tr>

            <tr>
                <td>Fecha Inicio</td>
                <td> {{ date('d/m/Y', strtotime($cursillos->fecha_inicio)) }} </td>
            </tr>
            <tr>
                <td>Fecha Final</td>
                <td> {{ date('d/m/Y', strtotime($cursillos->fecha_final)) }} </td>
            </tr>
            <tr>
                <td>Tipo Alumnos</td>
                <td>{{ $cursillos->tipo_alumnos }}</td>
            </tr>
            <tr>
                <td>Tipo Cursillo</td>
                <td>{{ $cursillos->tipo_cursillo }}</td>
            </tr>

            <tr>
                <td>Activo</td>
                <td>@if ($cursillos->activo == 0)No @else Si @endif</td>
            </tr>
            </tbody>
        </table>
        <div class="btn-action">
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