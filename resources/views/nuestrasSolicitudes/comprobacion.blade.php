@extends('plantillas.admin')
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
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
                                <i class="glyphicon glyphicon-envelope red "></i>
                            </span>
                        </div>

                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('nuestrasSolicitudes')}}" class="pull-left">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
            {!!FORM::model(Request::only(['nuestrasComunidades','restoComunidades','cursillo','semanas','anyos']),['route'=>'enviarNuestrasSolicitudes','method'=>'POST']) !!}
            {!! FORM::hidden('modalidad', $tipos_comunicaciones_preferidas)!!}
            {!! FORM::hidden('nuestrasComunidades', $nuestrasComunidades)!!}
            {!! FORM::hidden('anyo', $anyos)!!}
            {!! FORM::hidden('incluirSolicitudesAnteriores', $incluirSolicitudesAnteriores)!!}
            {!! FORM::hidden('restoComunidades', $restoComunidades)!!}
            <button type="submit" title="Enviar" class="pull-right">
                <i class='glyphicon glyphicon-envelope full-Width'>
                    <div>Enviar</div>
                </i>
            </button>
            {!! FORM::close() !!}
        </div>
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection