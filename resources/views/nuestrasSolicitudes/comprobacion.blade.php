@extends('plantillas.admin')
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima" style="margin-top: 110px">
        <br/>
        <table class="table-viaoptima table-striped table-hover">
            <thead>
            <tr>
                <th colspan="2">
                    {!! $titulo !!}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($incidencias as $incidencia)
                <tr>
                    <td>{{$incidencia}}</td>
                    <td width=1px class="text-right">
                        <div class="btn-action text-center">
                            <span title="realizado">
                                <i class="glyphicon glyphicon-envelope red icon-size-large"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!!FORM::model(Request::only(['modalidad','nuestrasComunidades','restoComunidades','incluirSolicitudesAnteriores','anyos']),['route'=>'enviarNuestrasSolicitudes','method'=>'POST']) !!}
        {!! FORM::hidden('modalidad', $tipos_comunicaciones_preferidas)!!}
        {!! FORM::hidden('nuestrasComunidades', $nuestrasComunidades)!!}
        {!! FORM::hidden('anyo', $anyos)!!}
        {!! FORM::hidden('generarSusRespuestas', $generarSusRespuestas)!!}
        {!! FORM::hidden('incluirSolicitudesAnteriores', $incluirSolicitudesAnteriores)!!}
        {!! FORM::hidden('restoComunidades', $restoComunidades)!!}
        @include('comun.plantillaVolverModificarGuardar',['index'=>"nuestrasSolicitudes",'accion'=>"Enviar", 'icon'=>'glyphicon-envelope'])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection