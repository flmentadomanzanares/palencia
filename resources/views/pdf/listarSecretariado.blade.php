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
                <div class="heading-caption">Seleccione el secretariado para imprimir ...</div>
                {!! FORM::label('comunidad', 'Secretariado') !!} <br/>
                {!! FORM::select('comunidad', $comunidades, null,array("class"=>"form-control",'id'=>'select_comunidad'))!!}
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
@section('js')
@endsection
