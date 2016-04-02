@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::open(['route' => 'provincias.store']) !!}
        @include('provincias.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"provincias.index",'accion'=>"Crear"])
    </div>
@endsection
@section("css")
@stop
@section('js')
    {!! HTML::script("js/comun/direccion.js")!!}
@endsection
