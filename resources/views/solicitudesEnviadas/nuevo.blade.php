@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::open(['route' => 'solicitudesEnviadas.store']) !!}
        @include('solicitudesEnviadas.parciales.nuevoYmodificar')
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('solicitudesEnviadas.index')}}" class="pull-left">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
            <button type="submit" title="Crear" class="pull-right">
                <i class='glyphicon glyphicon-plus full-Width'>
                    <div>Crear</div>
                </i>
            </button>
        </div>
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
    {!! HTML::script('js/comun/listarCursos.js') !!}
@endsection