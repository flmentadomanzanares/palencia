@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($tipoParticipante, ['route' => ['tiposParticipantes.update', $tipoParticipante->id], 'method' => 'patch']) !!}
        @include('tiposParticipantes.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"tiposParticipantes.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection