@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($pais, ['route' => ['paises.update', $pais->id], 'method' => 'patch']) !!}
        @include('paises.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"paises.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection