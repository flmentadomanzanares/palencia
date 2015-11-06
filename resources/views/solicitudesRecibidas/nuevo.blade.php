@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::open(['route' => 'solicitudesEnviadas.store']) !!}
        @include('solicitudesRecibidas.Parciales.nuevoYmodificar')
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('solicitudesRecibidas.index')}}" class="pull-left">
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
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
   {!! HTML::style("css/vendor/datepicker/datepicker.css") !!}
@stop
@section('js')
    {!! HTML::script('js/vendor/datepicker/datepicker.js') !!}
    {!! HTML::script('js/comun/date.js') !!}
@endsection