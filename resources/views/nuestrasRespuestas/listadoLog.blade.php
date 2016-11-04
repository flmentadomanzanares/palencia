@extends('plantillas.admin')
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima" style="margin-top:110px">
        <br/>
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
                    <td width=1px class="text-center">
                        @if(strlen($log[1])>0)
                            <div class="btn-action">
                                <a title="Descargar" href="{{$log[1]}}" download="{{$log[1]}}">
                                    <i class="glyphicon glyphicon-save">
                                        <div>{{isset($log[3])?$log[3]:"Guardar"}}</div>
                                    </i>
                                </a>
                            </div>
                        @else
                            <div class="btn-action text-center">
                            <span title="realizado">
                                 <i class="glyphicon glyphicon-{{$log[2]}}"></i>
                            </span>
                            </div>
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        @include('comun.plantillaVolverModificarGuardar',['index'=>"nuestrasRespuestas"])
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection