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
                <div class="heading-caption">Seleccione el numero del cursillo para imprimir ...</div>
                {!! FORM::label('num_cursillo', 'Cursillo') !!} <br/>
                {!! FORM::select('num_cursillo', $cursillos, null,array("class"=>"form-control"))!!}
                <br/>

                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="submit" title="Descargar" class="pull-right">
                        <i class='glyphicon glyphicon-save full-Width'>
                            <div>Descargar</div>
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
@section("css")
    {!! HTML::style("css/vendor/datepicker/datepicker.css") !!}
@stop
@section('js')
    {!! HTML::script('js/vendor/datepicker/datepicker.js') !!}
    {!! HTML::script('js/comun/date2.js') !!}

@endsection

