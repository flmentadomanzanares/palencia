@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($rol, ['route' => ['roles.update', $rol->id], 'method' => 'patch']) !!}
        @include('roles.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"roles.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection