@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!! FORM::open(['route'=>'imprimirComunidades','method'=>'POST']) !!}
                <div class="heading-caption">Seleccione rango de fechas para imprimir las comunidades ...</div>
                {!! FORM::label('fecha_inicio', 'Fecha Inicio') !!} <br/>
                {!! FORM::text('fecha_inicio',  date("d/m/Y",strtotime($cursillos->fecha_inicio)), ['id' => 'datepicker1', 'class' => 'form-control calendario', 'readonly'=>''])!!}
                <br/>
                <br/>
                {!! FORM::label('fecha_final', 'Fecha Final') !!} <br/>
                {!! FORM::text('fecha_final',  date("d/m/Y",strtotime($cursillos->fecha_final)), ['id' => 'datepicker2', 'class' => 'form-control calendario', 'readonly'=>''])!!}
                @include('comun.plantillaVolverModificarGuardar',['accion'=>"Descargar"])
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section("css")
    {!! HTML::style("css/vendor/datepicker/datepicker.css") !!}
@stop
@section('js')
    {!! HTML::script('js/vendor/datepicker/datepicker.js') !!}
    {!! HTML::script('js/comun/date2.js') !!}

@endsection

