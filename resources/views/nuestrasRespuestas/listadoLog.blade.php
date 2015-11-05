@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        <div style="width:100%;overflow: auto;padding:10px;">
            @foreach($logEnvios as $log)
                <p style="font-size: 16px" class="">{{$log}}</p>
            @endforeach
        </div>
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