@extends('plantillas.admin')

@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @if(count($anyos)>1)
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
                        <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                @if(config('opciones.accion.mostrarModalDeBorrado'))
                                class="pull-right lanzarModal"
                                data-title="BORRADO"
                                data-descripcion="¿Seguro que deseas eliminar los cursos y sus solicitudes?
                                                    <h3><strong class='green'></strong></h3>"
                                data-footer="true"
                                @endif >
                            <i class='glyphicon glyphicon-trash full-Width'>
                                <div>Borrar</div>
                            </i>
                        </button>
                        @if(config('opciones.accion.mostrarModalDeBorrado'))
                            @include ("comun.plantillaBorrado")
                        @endif
                    </div>
                    @if(config('opciones.accion.mostrarModalDeBorrado'))
                        @include('comun.plantillaBorrado')
                    @endif
                    {!! FORM::close() !!}
                @else
                    <div class="heading-caption">No hay cursillos que eliminar</div>
                    <div class="btn-action margin-bottom">
                        <a title="Inicio" href="{{route('inicio')}}" class="pull-right">
                            <i class="glyphicon glyphicon-home">
                                <div>Inicio</div>
                            </i>
                        </a>
                    </div>
                @endif
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
