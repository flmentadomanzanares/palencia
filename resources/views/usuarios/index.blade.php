@extends ("plantillas.admin")

@section ("titulo")
    <h1 class="text-center">{!! $titulo !!}</h1>
@stop
@section ("contenido")
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                <div class="row">
                    @include('usuarios.Parciales.buscar')
                </div>
            @endif
            @if(!$users->isEmpty())
                @foreach ($users as $usuario)
                    <table class="table-viaoptima table-striped">
                        <caption>
                            <img src="{!! asset('uploads/usuarios/'.$usuario->foto) !!}" alt=""/>

                            <div class="pull-left @if(!$usuario->activo) foreground-disabled @endif ">
                                {!! $usuario->fullname!!}
                            </div>
                        </caption>
                        <thead>
                        <tr @if(!$usuario->activo) class="background-disabled" @endif>
                            <th colspan="2" class="text-right">
                                <a title="Editar"
                                   href="{{route('usuarios.edit',array('id'=>$usuario->id))}}">
                                    <i class="glyphicon glyphicon-edit">
                                        <div>Editar</div>
                                    </i>
                                </a>
                                @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                    {!! FORM::open(array('route' => array('usuarios.destroy',
                                    $usuario->id),'method' => 'DELETE','title'=>'Borrar')) !!}
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
                        <tbody @if(!$usuario->activo) class="foreground-disabled" @endif>
                        <tr>
                            <td class="table-autenticado-columna-1">Usuario:</td>
                            <td>{!! $usuario->name !!}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{!! $usuario->email !!}</td>
                        </tr>
                        <tr>
                            <td>Rol</td>
                            <td>{!! ($usuario->roles->rol )!!}</td>
                        </tr>

                        @if (Auth::check())
                            @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                                <tr>
                                    <td>Activo</td>
                                    <td>{!! $usuario->activo?'Si':'No' !!}</td>
                                </tr>
                                <tr>
                                    <td>Confirmado</td>
                                    <td>{!! $usuario->confirmado?'Si':'No' !!}</td>
                                </tr>
                            @endif
                        @endif
                        <tr>
                            <td>Fecha Alta</td>
                            <td>{!! date("d/m/Y H:i:s",strtotime($usuario->created_at)) !!}</td>
                        </tr>
                        </tbody>
                    </table>
                @endforeach
                @if (Auth::user()->roles->peso<config('opciones.roles.administrador'))
                    <div class="btn-action">
                        <a title="Volver" href="{{route('inicio')}}" class="pull-right">
                            <i class="glyphicon glyphicon-home">
                                <div>Inicio</div>
                            </i>
                        </a>
                    </div>
                @endif
            @else
                <div class="clearfix">
                    <div class="alert alert-info" role="alert">
                        <p><strong>¡Aviso!</strong> No se ha encontrado ningún usuario que listar.</p>
                    </div>
                </div>
            @endif
            @if (Auth::user()->roles->peso>=config('opciones.roles.administrador'))
                <div class="row text-center">
                    {!! $users->appends(Request::only(['campo','value','rol']))->render()
                    !!}{{-- Poner el paginador --}}
                </div>
            @endif
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
@endsection
