@extends('plantillas.admin')
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima" style="margin-top: 130px">
        <table class="table-viaoptima table-striped table-hover">
            <caption>{!! $titulo !!}</caption>
            <thead>
            <tr class="row-fixed">
                <th class="text-center"></th>
                <th class="tabla-ancho-columna-botones"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($incidencias as $incidencia)
                <tr>
                    <td>{{$incidencia}}</td>
                    <td width=1px class="text-right">
                        <div class="btn-action text-center tabla-ancho-columna-botones">
                            <span title="realizado">
                                <i class="glyphicon glyphicon-envelope red icon-size-large"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!!FORM::model(Request::only([]),['route'=>'enviarNuestrasRespuestas','method'=>'POST']) !!}
        @foreach($cursosIds as $cursoId )
            {!! FORM::hidden('cursos[]', $cursoId)!!}
        @endforeach
        {!! FORM::hidden('nuestrasComunidades', $nuestrasComunidades)!!}
        @include('comun.plantillaVolverModificarGuardar',['index'=>"nuestrasRespuestas",'accion'=>"Enviar", 'icon'=>'glyphicon-envelope'])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection