@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($tipoComunicacionPreferida, ['route' => ['tiposComunicacionesPreferidas.update', $tipoComunicacionPreferida->id], 'method' => 'patch']) !!}
        @include('tiposComunicacionesPreferidas.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"tiposComunicacionesPreferidas.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
@endsection