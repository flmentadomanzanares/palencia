@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
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
                            <tr style="@if($comunidad->activo==0)background: red !important; @endif">
                                <th colspan="2" class="text-right">
                                    <a title="Mostrar"
                                       href="{{route('comunidades.show',$comunidad->id)}}">
                                        <i class="glyphicon glyphicon-eye-open">
                                            <div>Detalles</div>
                                        </i>
                                    </a>
                                    <a title="Editar"
                                       href="{{route('comunidades.edit',$comunidad->id)}}">
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
                                    {!! $comunidad->tipo_secretariado !!}
                                </td>
                            </tr>
                            <tr>
                                <td>Es Propia:</td>
                                <td> @if ($comunidad->esPropia) Si @else No @endif </td>
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
                                <td>Comunicación preferida:</td>
                                <td>{{$comunidad->comunicacion_preferida}}</td>
                            </tr>
                            <tr>
                                <td>Colabora:</td>
                                <td> @if ($comunidad->esColaborador) Si @else No @endif </td>
                            </tr>
                            <tr>
                                <td>Color Cursos:</td>
                                <td> <div class="ponerCirculoColor" style="background-color:{{$comunidad->color}}"></div></td>
                            </tr>
                            <tr>
                                <td>Activo:</td>
                                <td> @if ($comunidad->activo) Si @else No @endif </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @else
                <div class="">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ninguna comunidad que listar.</p>
                    </div>
                </div>
            @endif
            <div class="row text-center">
                {!! $comunidades->appends(Request::only(['comunidad','esPropia','secretariado','pais']))->render()
                !!}{{-- Poner el paginador --}}
            </div>
        @else
            @include('invitado')
        @endif
    </div>
@endsection
@section('js')
@endsection
