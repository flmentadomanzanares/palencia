@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if (Auth::check())
            <div class="row ">
                @include('solicitudesEnviadas.parciales.buscar')
            </div>
            @if(!$solicitudesEnviadas->isEmpty())
                @foreach ($solicitudesEnviadas as $solicitudEnviada)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <caption
                                    class="@if(!$solicitudEnviada->activo) foreground-disabled @endif">
                                {!! $solicitudEnviada->comunidad !!}
                            </caption>
                            <thead>
                            <tr @if(!$solicitudEnviada->activo) class="background-disabled" @endif>
                                <th colspan="2" class="text-right">
                                    <a title="Editar"
                                       href="{{route('solicitudesEnviadas.edit',array('id'=>$solicitudEnviada->id))}}">
                                        <i class="glyphicon glyphicon-edit">
                                            <div>Editar</div>
                                        </i>
                                    </a>
                                    {!! FORM::open(array('route' => 'cursillosSolicitudEnviada','method' => 'POST','title'=>'Mostrar Cursillos')) !!}
                                    {!! FORM::hidden('comunidad_id', $solicitudEnviada->comunidad_id) !!}
                                    {!! FORM::hidden('solicitud_id', $solicitudEnviada->id) !!}
                                    <button type="submit">
                                        <i class='glyphicon glyphicon-education full-Width'>
                                            <div>Cursillos</div>
                                        </i>
                                    </button>
                                    {!! FORM::close() !!}
                                    @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                    {{--{!! FORM::open(array('route' => array('solicitudesEnviadas.destroy',
                                    $solicitudEnviada->id),'method' => 'DELETE','title'=>'Borrar')) !!}
                                    <button type="submit">
                                        <i class='glyphicon glyphicon-trash full-Width'>
                                            <div>Borrar</div>
                                        </i>
                                    </button>
                                    {!! FORM::close() !!}--}}
                                    @endif
                                </th>
                            </tr>
                            </thead>
                            <tbody @if(!$solicitudEnviada->activo) class="foreground-disabled" @endif>
                            <tr>
                                <td class="table-autenticado-columna-1">Fecha de Envio:</td>
                                <td>{!! Date("d/m/Y - H:i:s" , strtotime($solicitudEnviada->created_at) )!!}</td>
                            </tr>
                            <tr>
                                <td>Aceptada:</td>
                                <td> @if ($solicitudEnviada->aceptada ) Si @else No @endif </td>
                            </tr>
                            <tr>
                                <td>Activo:</td>
                                <td> @if ($solicitudEnviada->activo ) Si @else No @endif </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ninguna solicitud que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row paginationBlock">
                {!! $solicitudesEnviadas->appends(Request::only(['comunidades', 'aceptada']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanasSolicitudesEnviadas.js') !!}
@endsection
