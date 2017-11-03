@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @if(count($anyos)>0)
                    {!! FORM::open(['route'=>'imprimirCursillos','method'=>'POST']) !!}
                    <div class="heading-caption">Seleccione a&ntilde;o y semana para imprimir los cursillos ...</div>
                    {!! FORM::label('anyo', 'A&ntilde;o') !!} <br/>
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                    <br/>
                    {!! FORM::label('semana', 'Semana') !!} <br/>
                    {!! FORM::select('semana', $semanas, null,array("class"=>"form-control",'id'=>'select_semanas'))!!}
                    <br/>
                    @include('comun.plantillaVolverModificarGuardar',['accion'=>"Bajar"])
                    {!! FORM::close() !!}
                @else
                    <div class="heading-caption">No existen solicitudes recibidas</div>
                    @include('comun.plantillaVolverModificarGuardar',['index'=>"inicio"])
                @endif
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    @if(count($anyos)>0)
    {!! HTML::script('js/comun/semanasSolicitudesRecibidasCursillos.js') !!}
    @endif
@endsection
