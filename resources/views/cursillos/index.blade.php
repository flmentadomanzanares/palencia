@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'cursillos.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'cursillos','accion'=>'Nuevo'])
            @if(!$cursillos->isEmpty())
                @foreach ($cursillos as $cursillo)
                    <table class="table-viaoptima table-striped">
                        <caption class="@if(!$cursillo->activo) foreground-disabled @endif">
                            {!! $cursillo->cursillo !!}
                        </caption>
                        <thead>
                        <tr @if(!$cursillo->activo) class="background-disabled"
                            @else style="background-color:{{$cursillo->colorFondo}};" @endif>
                            <th colspan="2" class="text-right">
                                <a title="Mostrar"
                                   href="{{route('cursillos.show',$cursillo->id)}}">
                                    <i class="glyphicon glyphicon-eye-open">
                                        <div style>Detalles</div>
                                    </i>
                                </a>
                                <a title="Editar"
                                   href="{{route('cursillos.edit',$cursillo->id)}}">
                                    <i class="glyphicon glyphicon-edit">
                                        <div>Editar</div>
                                    </i>
                                </a>
                                @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                @if($cursillo->activo)
                                    {!! FORM::open(array('route' => array('cursillos.destroy',
                                    $cursillo->id),'method' => 'DELETE','title'=>(config('opciones.accion.mostrarModalDeBorrado')?'':'Borrar')))!!}
                                    <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                            @if(config('opciones.accion.mostrarModalDeBorrado'))
                                            class="pull-right lanzarModal simpleModal"
                                            data-modal_sin_etiqueta="true"
                                            data-modal_ancho="330"
                                            data-modal_cabecera_color_fondo='rgba(255,0,0,.9)'
                                            data-modal_cabecera_color_texto='#ffffff'
                                            data-modal_cuerpo_color_fondo='rgba(255,255,255,.9)'
                                            data-modal_cuerpo_color_texto='"#ffffff'
                                            data-modal_pie_color_fondo='#400090'
                                            data-modal_pie_color_texto='"#ffffff'
                                            data-modal_posicion_vertical="220"
                                            data-titulo="BORRAR"
                                            data-pie="true"
                                            data-descripcion="¿Seguro que deseas eliminar este cursillo?
                                            <h3><strong class='green'>{{$cursillo->comunidad}}</strong></h3>
                                            <h3><strong class='green'>Nº{{$cursillo->num_cursillo}}</strong></h3>"
                                            @endif >
                                        <i class='glyphicon glyphicon-trash full-Width'>
                                            <div>Borrar</div>
                                        </i>
                                    </button>
                                    @if(config('opciones.accion.mostrarModalDeBorrado'))
                                        @include ("comun.plantillaBorrado")
                                    @endif
                                    {!! FORM::close() !!}
                                @endif
                                @endif
                            </th>
                        </tr>
                        </thead>
                        <tbody @if(!$cursillo->activo) class="foreground-disabled" @endif>
                        <tr>
                            <td class="table-autenticado-columna-1">Comunidad:</td>
                            <td>
                                {!! $cursillo->comunidad !!}
                            </td>
                        </tr>
                        <tr>
                            <td>Número:</td>
                            <td>{!!$cursillo->num_cursillo!!}</td>
                        </tr>
                        <tr>
                            <td>Año ISO-8601:</td>
                            <td>{!! Date("o" , strtotime($cursillo->fecha_inicio) )!!}</td>
                        </tr>
                        <tr>
                            <td>Semana ISO-8601:</td>
                            <td>{!! Date("W" , strtotime($cursillo->fecha_inicio) )!!}</td>
                        </tr>
                        <tr>
                            <td>Asistentes:</td>
                            <td>{!!$cursillo->tipo_participante!!}</td>
                        </tr>
                        @if($cursillo->esPropia)
                            <tr>
                                <td>Emitida Solicitud:</td>
                                <td> @if ($cursillo->esSolicitud ) Si @else No @endif </td>
                            </tr>
                        @else
                            <tr>
                                <td>Emitida Respuesta:</td>
                                <td> @if ($cursillo->esRespuesta ) Si @else No @endif </td>
                            </tr>
                        @endif
                        <tr>
                            <td>Activo:</td>
                            <td> @if ($cursillo->activo ) Si @else No @endif </td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                {!! $cursillos->appends(Request::only(['comunidad','cursillo','semanas','anyos']))->render()!!}
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun cursillo que listar.</p>
                    </div>
                </div>
            @endif
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanas.js') !!}
@endsection
