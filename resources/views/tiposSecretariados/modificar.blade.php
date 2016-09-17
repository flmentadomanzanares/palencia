@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::model($tipoSecretariado, ['route' => ['tiposSecretariados.update', $tipoSecretariado->id], 'method' => 'patch']) !!}
        @include('tiposSecretariados.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"tiposSecretariados.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection