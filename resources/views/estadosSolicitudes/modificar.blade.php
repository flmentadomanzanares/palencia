@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::model($estados_solicitudes, ['route' => ['estadosSolicitudes.update', $estados_solicitudes->id],
        'method' => 'patch']) !!}
        @include('estadosSolicitudes.parciales.nuevoYmodificar')
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('estadosSolicitudes.index')}}" class="pull-left">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
            <button type="submit" title="Guardar" class="pull-right">
                <i class='glyphicon glyphicon-floppy-disk full-Width'>
                    <div>Guardar</div>
                </i>
            </button>
        </div>
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
    {!! HTML::style("css/vendor/ColorPicker/jquery.simplecolorpicker.css")!!}
@stop
@section('js')
    {!! HTML::script("js/vendor/ColorPicker/jquery.simplecolorpicker.js")!!}
    {!! HTML::script("js/comun/color.js")!!}
@endsection