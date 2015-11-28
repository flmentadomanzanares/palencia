@extends('plantillas.admin')
@section('titulo')

@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        <table class="table-viaoptima table-striped table-hover">
            <thead>
            <tr>
                <th colspan="2">
                    {!! $titulo !!}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($logEnvios as $log)
                <tr>
                    <td>{{$log[0]}}</td>
                    <td width=1px class="text-right">
                        @if(strlen($log[1])>0)
                            <div class="btn-action">
                                <a title="Descargar" href="{{$log[1]}}" download="{{$log[1]}}" class="pull-left">
                                    <i class="glyphicon glyphicon-print">
                                        <div>Imprimir</div>
                                    </i>
                                </a>
                            </div>
                        @else
                            <div class="btn-action text-center">
                            <span title="realizado">
                                <i class="glyphicon @if($log[2])glyphicon-check green @else glyphicon-remove red @endif"></i>
                            </span>
                            </div>
                        @endif
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('nuestrasRespuestas.index')}}" class="pull-left">
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