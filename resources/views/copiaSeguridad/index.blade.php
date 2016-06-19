@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div>
                {!!FORM::model(Request::only(['nuestrasComunidades']),['route'=>'comenzarCopiaSeguridad','method'=>'POST']) !!}
                <div class="heading-caption">Comunidad</div>
                {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control"))!!}
                <br/>
                @include('comun.plantillaVolverModificarGuardar',['accion'=>"Copia"])
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
