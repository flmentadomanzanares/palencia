@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        <table class="table-viaoptima table-striped">
            <thead>
            <tr style="@if($cursillo->activo==0)background: red !important; @endif">
                <th colspan="2" class="text-center">
                    {!! $cursillo->cursillo !!}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="table-autenticado-columna-1">Comunidad:</td>
                <td>
                    {!! $cursillo->comunidad !!}
                </td>
            </tr>
            <tr>
                <td>Número:</td>
                <td>{!!$cursillo->num_cursillo!!}</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>{!! $cursillo->tipo_cursillo!!}</td>
            </tr>
            <tr>
                <td>Semana:</td>
                <td>{!! Date("W" , strtotime($cursillo->fecha_inicio) )!!}</td>
            </tr>
            <tr>
                <td>Fecha Inicio:</td>
                <td>{!! Date("d/m/Y" , strtotime($cursillo->fecha_inicio) )!!}</td>
            </tr>
            <tr>
                <td>Fecha Final:</td>
                <td>{!! Date("d/m/Y" , strtotime($cursillo->fecha_final) )!!}</td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td>
                    {!! $cursillo->descripcion !!}
                </td>
            </tr>
            <tr>
                <td>Asistentes:</td>
                <td>{!!$cursillo->tipo_participante!!}</td>
            </tr>
            <tr>
                <td>Activo:</td>
                <td> @if ($cursillo->activo ) Si @else No @endif </td>
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