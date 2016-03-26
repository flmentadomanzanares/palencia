@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden">
        <div class="row table-size-optima">
            {!! FORM::open(['route' => 'paises.store']) !!}
            @include('paises.parciales.nuevoYmodificar')
            @include('comun.volverModificarGuardar',['index'=>"paises.index",'accion'=>"Crear"])
            {!! FORM::close() !!}
        </div>
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection
