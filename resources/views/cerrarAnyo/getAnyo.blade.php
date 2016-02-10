@extends('plantillas.admin')

@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!! FORM::open(['route'=>'borrarTablas','method'=>'POST']) !!}
                <div class="alert alert-danger" role="alert">
                    ¡¡AVISO!!: Al pulsar "Borrar" se borraran todos los registros de cursillos y solicitudes del año
                    seleccionado.
                </div>
                <div class="heading-caption">Seleccione año a cerrar ...</div>
                {!! FORM::label('anyo', 'Año') !!} <br/>
                {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                <br/>

                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="button" id="delete" class="pull-right" data-toggle="modal"
                            data-target="#verificarBorrado">
                        <i class='glyphicon glyphicon-trash full-Width'>
                            <div>Borrar</div>
                        </i>
                    </button>
                </div>
                @if(config('opciones.accion.mostrarModalDeBorrado'))
                    @include('comun.verificarBorrado')
                @endif
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanasSolicitudesRecibidasCursillos.js') !!}
@endsection
