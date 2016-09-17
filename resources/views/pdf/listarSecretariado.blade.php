@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!! FORM::open(['route'=>'imprimirSecretariado','method'=>'POST']) !!}
                <div class="heading-caption">Seleccione a&ntilde;o y secretariado para imprimir ...</div>
                {!! FORM::label('anyo', 'A&ntilde;o') !!} <br/>
                {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                <br/>
                {!! FORM::label('comunidad', 'Secretariado') !!} <br/>
                {!! FORM::select('comunidad', $comunidades, null,array("class"=>"form-control",'id'=>'select_comunidad'))!!}
                @include('comun.plantillaVolverModificarGuardar',['accion'=>"Descargar"])
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
