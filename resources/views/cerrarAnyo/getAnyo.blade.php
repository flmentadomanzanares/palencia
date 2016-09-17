@extends('plantillas.admin')

@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @if(count($anyos)>0)
                <div class="alert alert-warning" role="alert">
                    ¡¡AVISO!!: Al pulsar "Borrar" se borrar&aacute;n todos los registros de cursillos y solicitudes del
                    a&ntilde;o
                    seleccionado.
                </div>
                <div class="heading-caption">Seleccione a&ntilde;o a cerrar ...</div>
                {!! FORM::open(['route'=>'borrarTablas','method'=>'POST']) !!}
                <div class="form-group">
                    {!! FORM::label('anyo', 'A&ntilde;o') !!}
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>
                @include('comun.plantillaAccionBorrarAnyos')
                @if(config('opciones.accion.mostrarModalDeBorrado'))
                    @include ("comun.plantillaBorrado")
                @endif
                {!! FORM::close() !!}
            @else
                <div class="heading-caption">No hay cursillos que eliminar</div>
            @endif
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
