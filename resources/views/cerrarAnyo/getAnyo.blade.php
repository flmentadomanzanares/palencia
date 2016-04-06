@extends('plantillas.admin')

@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @if(count($anyos)>1)
                <div class="alert alert-danger" role="alert">
                    ¡¡AVISO!!: Al pulsar "Borrar" se borraran todos los registros de cursillos y solicitudes del año
                    seleccionado.
                </div>
                <div class="heading-caption">Seleccione año a cerrar ...</div>
                {!! FORM::open(['route'=>'borrarTablas','method'=>'POST']) !!}
                <div class="form-group">
                    {!! FORM::label('anyo', 'Año') !!}
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>
                @include('comun.plantillaAccionBorrarAnyos')
                @if(config('opciones.accion.mostrarModalDeBorrado'))
                    @include ("comun.plantillaBorrado")
                @endif
                {!! FORM::close() !!}
    </div>

    @else
        <div class="heading-caption">No hay cursillos que eliminar</div>
        @endif
        @else
        @include('comun.guestGoHome')
        @endif
        </div>
@endsection
@section('js')
    @if(!config('opciones.accion.mostrarModalDeBorrado'))
    @endif
@endsection
