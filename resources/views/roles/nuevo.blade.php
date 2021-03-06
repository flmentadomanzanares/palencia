@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::open(['route' => 'roles.store']) !!}
        @include('roles.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"roles.index",'accion'=>"Crear"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection


