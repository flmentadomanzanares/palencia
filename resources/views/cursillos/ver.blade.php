@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        <table class="table-viaoptima table-striped">
            <thead>
            <tr @if(!$cursillo->activo) class="background-disabled"
                @else style="background-color:{{$cursillo->colorFondo}};" @endif>
                <th colspan="2" class="text-center"
                    @if($cursillo->activo) style="color:{{$cursillo->colorTexto}}" @endif>
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
                <td>Año ISO-8601:</td>
                <td>{!! Date("o" , strtotime($cursillo->fecha_inicio) )!!}</td>
            </tr>
            <tr>
                <td>Semana ISO-8601:</td>
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
            @if (Auth::check())
                @if(Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                    @if($cursillo->esPropia)
                        <tr>
                            <td>Emitida Solicitud:</td>
                            <td> @if ($cursillo->esSolicitud ) Si @else No @endif </td>
                        </tr>
                    @else
                        <tr>
                            <td>Emitida Respuesta:</td>
                            <td> @if ($cursillo->esRespuesta ) Si @else No @endif </td>
                        </tr>
                    @endif
                    <tr>
                        <td>Activo:</td>
                        <td> @if ($cursillo->activo ) Si @else No @endif </td>
                    </tr>
                @endif
            @endif
            </tbody>
        </table>
        @include('comun.plantillaVolverModificarGuardar',['index'=>($esInicio)?"inicio":"cursillos.index",'accion'=>""])
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection