@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($solicitudEnviada, ['route' => ['solicitudesEnviadas.update', $solicitudEnviada->id], 'method' => 'patch']) !!}
        @include('solicitudesEnviadas.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"solicitudesEnviadas.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection