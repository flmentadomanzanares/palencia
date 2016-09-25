@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'solicitudesEnviadas.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'solicitudesEnviadas'])
            @if(!$solicitudesEnviadas->isEmpty())
                @foreach ($solicitudesEnviadas as $solicitudEnviada)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <thead>
                            <tr class="row-fixed">
                                <th class="tabla-ancho-columna-texto"></th>
                                <th></th>
                            </tr>
                            <tr @if(!$solicitudEnviada->activo) class="background-disabled"
                                @else style="background-color:{{$solicitudEnviada->color}};" @endif>
                                <th colspan="2" class="text-right">
                                    <a title="Editar"
                                       href="{{route('solicitudesEnviadas.edit',array('id'=>$solicitudEnviada->id))}}">
                                        <i class="glyphicon glyphicon-edit">
                                            <div>Editar</div>
                                        </i>
                                    </a>
                                    @if($solicitudEnviada->activo && $solicitudEnviada->aceptada)
                                        {!! FORM::open(array('route' => 'cursillosSolicitudEnviada','method' =>
                                        'POST','title'=>'Mostrar Cursillos')) !!}
                                        {!! FORM::hidden('comunidad_id', $solicitudEnviada->comunidad_id) !!}
                                        {!! FORM::hidden('solicitud_id', $solicitudEnviada->id) !!}
                                        <button type="submit">
                                            <i class='glyphicon glyphicon-education full-Width'>
                                                <div>Cursillos</div>
                                            </i>
                                        </button>
                                    @endif
                                    {!! FORM::close() !!}
                                    @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador') && $solicitudEnviada->esManual == true) {{--Administrador --}}
                                    {!! FORM::open(array('route' => array('solicitudesEnviadas.destroy',
                                    $solicitudEnviada->id),'method' => 'DELETE','title'=>'Borrar')) !!}
                                    <button type="@if(config('opciones.accion.mostrarModalDeBorrado'))button @else submit @endif"
                                            @if(config('opciones.accion.mostrarModalDeBorrado'))
                                            class="pull-right simpleModal"
                                            data-modal_centro_pantalla="true"
                                            data-modal_en_la_derecha="false"
                                            data-modal_sin_etiqueta="true"
                                            data-modal_ancho="330"
                                            data-modal_cabecera_color_fondo='rgba(255,0,0,.9)'
                                            data-modal_cabecera_color_texto='#ffffff'
                                            data-modal_cuerpo_color_fondo='rgba(255,255,255,1)'
                                            data-modal_cuerpo_color_texto='"#ffffff'
                                            data-modal_pie_color_fondo='#400090'
                                            data-modal_pie_color_texto='"#ffffff'
                                            data-modal_posicion_vertical="220"
                                            data-titulo="BORRAR"
                                            data-pie="true"
                                            data-descripcion="¿Seguro que deseas eliminar esta respuesta?
                                                        <h3><strong class='green'>{!! $solicitudEnviada->comunidad !!}</strong></h3>
                                                        <h4>Fecha : {!! Date("d/m/Y - H:i:s" , strtotime($solicitudEnviada->created_at) )!!}</h4>"
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
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="cabecera">
                                    <div class="ellipsis text-center @if(!$solicitudEnviada->activo) foreground-disabled @endif"
                                         @if($solicitudEnviada->activo==1) style="background-color:{{$solicitudEnviada->colorFondo}} !important;
                                                 color:{{$solicitudEnviada->colorTexto}} !important; @endif ">
                                        {!! $solicitudEnviada->comunidad !!}
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody @if(!$solicitudEnviada->activo) class="foreground-disabled" @endif>
                            <tr>
                                <td>Fecha de Envio:</td>
                                <td>{!! Date("d/m/Y - H:i:s" , strtotime($solicitudEnviada->created_at) )!!}</td>
                            </tr>
                            <tr>
                                <td>Aceptada:</td>
                                <td> @if ($solicitudEnviada->aceptada ) Si @else No @endif </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
                {!! $solicitudesEnviadas->appends(Request::only(['comunidades', 'aceptada','esActivo']))->render()!!}
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ninguna solicitud que listar.</p>
                    </div>
                </div>
            @endif
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection