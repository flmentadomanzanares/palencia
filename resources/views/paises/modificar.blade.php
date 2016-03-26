@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::model($pais, ['route' => ['paises.update', $pais->id], 'method' => 'patch']) !!}
        @include('paises.parciales.nuevoYmodificar')
        @include('comun.volverModificarGuardar',['index'=>"paises.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection