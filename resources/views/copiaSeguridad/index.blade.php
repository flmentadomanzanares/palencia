@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center"><{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!!FORM::model(Request::only(['nuestrasComunidades']),['route'=>'comenzarCopiaSeguridad','method'=>'POST']) !!}
                <div class="heading-caption">Comunidad</div>
                {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control"))!!}
                <br/>


                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="submit" title="Enviar" class="pull-right">
                        <i class='glyphicon glyphicon-floppy-disk full-Width'>
                            <div>Copia</div>
                        </i>
                    </button>
                </div>
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
