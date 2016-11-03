@extends('plantillas.admin')
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima" style="margin-top:110px">
        <table class="table-viaoptima table-striped table-hover">
            <caption>{!! $titulo !!}</caption>
            <thead>
            <tr class="row-fixed">
                <th></th>
                <th class="tabla-ancho-columna-botones"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($logEnvios as $log)
                <tr>
                    <td>{{$log[0]}}</td>
                    <td class="text-center">
                        @if(strlen($log[1])>0)
                            <div class="btn-action">
                                <a title="Descargar" href="{{$log[1]}}" download="{{$log[1]}}">
                                    <i class="glyphicon glyphicon-save">
                                        <div>Guardar</div>
                                    </i>
                                </a>
                            </div>
                        @else
                            <span title="realizado">
                                <i class="glyphicon glyphicon-{{$log[2]}}"></i>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('comun.plantillaVolverModificarGuardar',['index'=>"nuestrasSolicitudes"])
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection