@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!! FORM::open(['route'=>'imprimirNoColaboradoresInactivos','method'=>'POST']) !!}
                <div class="heading-caption">Seleccione el pa&iacute;s para imprimir los secretariados ...</div>
                {!! FORM::label('pais', 'Pa&iacute;s') !!} <br/>
                {!! FORM::select('pais', $paises, null,array("class"=>"form-control",'id'=>'select_paises'))!!}
                @include('comun.plantillaVolverModificarGuardar',['accion'=>"Bajar"])
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
