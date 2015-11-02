@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!!FORM::model(Request::only(['solicitudesRecibidas','semanas','anyos']),['route'=>'imprimirCursillos','method'=>'POST']) !!}
                <div class="heading-caption">Fecha Cursillos</div>
                {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                <br/>
                {!! FORM::select('semana', $semanas, null,array("class"=>"form-control",'id'=>'select_semanas'))!!}
                <br/>
                <div class="heading-caption">Cursillos Seleccionados</div>
                <div id="listado_cursillos" class="" style="max-height:250px;overflow-y: auto "></div>
                <br/>
                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="submit" title="Enviar" class="pull-right">
                        <i class='glyphicon glyphicon-envelope full-Width'>
                            <div>Enviar</div>
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
    {!! HTML::script('js/comun/semanas.js') !!}
@endsection
