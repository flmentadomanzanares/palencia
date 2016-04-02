@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($provincia, ['route' => ['provincias.update', $provincia->id], 'method' => 'patch']) !!}
        @include('provincias.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"provincias.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
    {!! HTML::script("js/comun/direccion.js")!!}
@endsection