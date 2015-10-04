@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            <div class="row ">
                @include('comunidades.parciales.buscar')
            </div>
            @if(!$comunidades->isEmpty())
                @foreach ($comunidades as $comunidad)
                    <div>
                        <table class="table-viaoptima table-striped">
                            <caption>
                                {!! $comunidad->comunidad !!}
                            </caption>
                            <thead>
                            <tr>
                                <th colspan="2" class="text-right">
                                    <a title="Mostrar"
                                       href="{{route('comunidades.show',array('id'=>$comunidad->id))}}">
                                        <i class="glyphicon glyphicon-eye-open">
                                            <div>Detalles</div>
                                        </i>
                                    </a>
                                    <a title="Editar"
                                       href="{{route('comunidades.edit',array('id'=>$comunidad->id))}}">
                                        <i class="glyphicon glyphicon-edit">
                                            <div>Editar</div>
                                        </i>
                                    </a>
                                    @if ((Auth::user()->roles->peso)>=config('opciones.roles.administrador')){{--Administrador --}}
                                    {!! FORM::open(array('route' => array('comunidades.destroy',
                                    $comunidad->id),'method' => 'DELETE','title'=>'Borrar')) !!}
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
                                <td class="table-autenticado-columna-1">Secretariado:</td>
                                <td>
                                    {!! $comunidad->secretariado !!}
                                </td>
                            </tr>
                            <tr>
                                <td>País:</td>
                                <td>
                                    {!! $comunidad->pais !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Provincia:</td>
                                <td>
                                    {!! $comunidad->provincia !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Localidad:</td>
                                <td>
                                    {!! $comunidad->localidad !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Responsable:</td>
                                <td>
                                    {!! $comunidad->responsable !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Dirección:</td>
                                <td>
                                    {!! $comunidad->direccion !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Activa:</td>
                                <td> @if ($comunidad->activa ) Si @else No @endif </td>
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
                {!! $comunidades->appends(Request::only(['comunidad']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
