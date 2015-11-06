@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                @include('solicitudesRecibidas.parciales.buscar')
            </div>
            @if(!$solicitudesRecibidas->isEmpty())
                @foreach ($solicitudesRecibidas as $solicitudRecibida)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <caption>
                                {!! $solicitudRecibida->cursillo !!}
                            </caption>
                            <thead>
                            <tr style="@if($solicitudRecibida->activo==0)background: red !important; @endif">
                                <th colspan="2" class="text-right">
                                    <a title="Editar"
                                       href="{{route('solicitudesRecibidas.edit',array('id'=>$solicitudRecibida->id))}}">
                                        <i class="glyphicon glyphicon-edit">
                                            <div>Editar</div>
                                        </i>
                                    </a>
                                    @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                    {!! FORM::open(array('route' => array('solicitudesRecibidas.destroy',
                                    $solicitudRecibida->id),'method' => 'DELETE','title'=>'Borrar')) !!}
                                    <button type="submit">
                                        <i class='glyphicon glyphicon-trash full-Width'>
                                            <div>Borrar</div>
                                        </i>
                                    </button>
                                    {!! FORM::close() !!}
                                    @endif
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="table-autenticado-columna-1">Solicitud Id:</td>
                                <td>
                                    {!! $solicitudRecibida->id !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Comunidad:</td>
                                <td>{!!$solicitudRecibida->comunidad!!}</td>
                            </tr>
                            <tr>
                                <td>Año Cursillo:</td>
                                <td>{!! Date("Y" , strtotime($solicitudRecibida->fecha_inicio) )!!}</td>
                            </tr>
                            <tr>
                                <td>Semana Cursillo:</td>
                                <td>{!! Date("W" , strtotime($solicitudRecibida->fecha_inicio) )!!}</td>
                            </tr>
                            <tr>
                                <td>Activo:</td>
                                <td> @if ($solicitudRecibida->activo ) Si @else No @endif </td>
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
            <div class="row text-center">
                {!! $solicitudesRecibidas->appends(Request::only(['semanas','anyos']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanas.js') !!}
@endsection
