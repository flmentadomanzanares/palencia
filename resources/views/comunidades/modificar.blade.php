@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($comunidad, ['route' => ['comunidades.update', $comunidad->id], 'method' => 'patch']) !!}
        @include('comunidades.parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>"comunidades.index",'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
    {!! HTML::style("css/vendor/ColorPicker/jquery.simplecolorpicker.css")!!}
@stop
@section('js')
    {!! HTML::script('js/comun/direccion.js') !!}
    {!! HTML::script("js/vendor/ColorPicker/jquery.simplecolorpicker.js")!!}
    {!! HTML::script("js/comun/color.js")!!}
@endsection
