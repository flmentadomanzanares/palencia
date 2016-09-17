@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::open(['route' => 'tiposParticipantes.store']) !!}
        @include('tiposParticipantes.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"tiposParticipantes.index",'accion'=>"Crear"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection
