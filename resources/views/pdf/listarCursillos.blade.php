@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!! FORM::open(['route'=>'imprimirCursillos','method'=>'POST']) !!}
                <div class="heading-caption">Seleccione año y semana para imprimir los cursillos ...</div>
                {!! FORM::label('anyo', 'Año') !!} <br/>
                {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                <br/>
                {!! FORM::label('semana', 'Semana') !!} <br/>
                {!! FORM::select('semana', $semanas, null,array("class"=>"form-control",'id'=>'select_semanas'))!!}
                <br/>

                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="submit" title="Enviar" class="pull-right">
                        <i class='glyphicon glyphicon-print full-Width'>
                            <div>Imprimir</div>
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
    {!! HTML::script('js/comun/semanasSolicitudesRecibidas.js') !!}
@endsection
