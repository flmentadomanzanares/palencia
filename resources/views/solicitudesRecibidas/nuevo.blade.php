@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::open(['route' => 'solicitudesRecibidas.store']) !!}
        @include('solicitudesRecibidas.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"solicitudesRecibidas.index",'accion'=>"Crear"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')

@endsection