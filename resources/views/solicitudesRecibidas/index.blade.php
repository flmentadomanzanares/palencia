@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if (Auth::check())
            @include('comun.plantillaBuscarIndex',['htmlTemplate'=>'solicitudesRecibidas.parciales.buscar'])
            @include('comun.plantillaOperacionesIndex',['tabla'=>'solicitudesRecibidas'])
            @if(!$solicitudesRecibidas->isEmpty())
                @foreach ($solicitudesRecibidas as $solicitudRecibida)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <thead>
                            <tr class="row-fixed">
                                <th class="tabla-ancho-columna-texto"></th>
                                <th></th>
                            </tr>
                            <tr @if(!$solicitudRecibida->activo) class="background-disabled"@endif>
                                <th colspan="2" class="text-right">
                                    <a title="Editar"
                                       href="{{route('solicitudesRecibidas.edit',array('id'=>$solicitudRecibida->id))}}">
                                        <i class="glyphicon glyphicon-edit">
                                            <div>Editar</div>
                                        </i>
                                    </a>
                                    @if($solicitudRecibida->activo && $solicitudRecibida->aceptada)
                                        {!! FORM::open(array('route' => 'cursillosSolicitudRecibida','method' =>
                                        'POST','title'=>'Mostrar Cursillos')) !!}
                                        {!! FORM::hidden('comunidad_id', $solicitudRecibida->comunidad_id) !!}
                                        {!! FORM::hidden('solicitud_id', $solicitudRecibida->id) !!}
                                        <button type="submit">
                                            <i class='glyphicon glyphicon-education full-Width'>
                                                <div>Cursillos</div>
                                            </i>
                                        </button>
                                    @endif
                                    {!! FORM::close() !!}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="cabecera">
                                    <div class="ellipsis text-center @if(!$solicitudRecibida->activo) c-white background-disabled @endif"
                                         style="@if($solicitudRecibida->activo) background-color:{{$solicitudRecibida->colorFondo}} !important;
                                                 color:{{$solicitudRecibida->colorTexto}}@endif ">
                                        {!! $solicitudRecibida->comunidad !!}
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody @if(!$solicitudRecibida->activo) class="foreground-disabled" @endif>
                            <tr>
                                <td>Fecha de Envio:</td>
                                <td>{!! Date("d/m/Y - H:i:s" , strtotime($solicitudRecibida->created_at) )!!}</td>
                            </tr>
                            <tr>
                                <td>Respondida:</td>
                                <td> @if ($solicitudRecibida->aceptada ) Si @else No @endif </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
                {!! $solicitudesRecibidas->appends(Request::only(['comunidades', 'aceptada','esActivo','esActual']))->render()!!}
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
