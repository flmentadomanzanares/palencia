@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            <div class="row ">
                @include('cursillos.parciales.buscar')
            </div>
            @if(!$cursillos->isEmpty())
                @foreach ($cursillos as $cursillo)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <caption>
                                {!! $cursillo->cursillo !!}
                            </caption>
                            <thead>
                            <tr>
                                <th colspan="2" class="text-right">
                                    <a title="Mostrar"
                                       href="{{route('cursillos.show',array('id'=>$cursillo->id))}}">
                                        <i class="glyphicon glyphicon-eye-open">
                                            <div>Detalles</div>
                                        </i>
                                    </a>
                                    <a title="Editar"
                                       href="{{route('cursillos.edit',array('id'=>$cursillo->id))}}">
                                        <i class="glyphicon glyphicon-edit">
                                            <div>Editar</div>
                                        </i>
                                    </a>
                                    @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                    {!! FORM::open(array('route' => array('cursillos.destroy',
                                    $cursillo->id),'method' => 'DELETE','title'=>'Borrar')) !!}
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
                                <td class="table-autenticado-columna-1">Comunidad:</td>
                                <td>
                                    {!! $cursillo->comunidades->comunidad !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Descripción:</td>
                                <td>
                                    {!! $cursillo->descripcion !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha Inicio:</td>
                                <td>{!! Date("d/m/Y" , strtotime($cursillo->fecha_inicio) )!!}</td>
                            </tr>
                            <tr>
                                <td>Fecha Final:</td>
                                <td>{!! Date("d/m/Y" , strtotime($cursillo->fecha_final) )!!}</td>
                            </tr>
                            <tr>
                                <td>Descripción:</td>
                                <td>
                                    {!! $cursillo->descripcion !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha Creación:</td>
                                <td>{!! Date("d/m/Y - H:i:s" , strtotime($cursillo->created_at) )!!}</td>
                            </tr>
                            <tr>
                                <td>Activo:</td>
                                <td> @if ($cursillo->activo ) Si @else No @endif </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningun cursillo que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row text-center">
                {!! $cursillos->appends(Request::only(['cursillo']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
