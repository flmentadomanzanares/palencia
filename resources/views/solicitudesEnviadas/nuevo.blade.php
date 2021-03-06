@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::open(['route' => 'solicitudesEnviadas.store']) !!}
        @include('solicitudesEnviadas.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"solicitudesEnviadas.index",'accion'=>"Crear"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection