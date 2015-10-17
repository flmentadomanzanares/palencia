@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::open(['route' => 'provincias.store']) !!}
        @include('provincias.parciales.nuevoYmodificar')
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('provincias.index')}}" class="pull-left">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
            <button type="submit" title="Crear" class="pull-right">
                <i class='glyphicon glyphicon-plus full-Width'>
                    <div>Crear</div>
                </i>
            </button>
        </div>
    </div>
@endsection
@section("css")
    {!! HTML::style("css/vendor/chosen/chosen.min.css") !!}
    {{--{!! HTML::style("css/vendor/datepicker/datepicker.css") !!} --}}
@stop
@section('js')
    {!! HTML::script("js/comun/direccion.js")!!}
@endsection
