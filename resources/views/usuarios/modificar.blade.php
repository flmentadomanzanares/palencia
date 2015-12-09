@extends ("plantillas.admin")

@section ("titulo")
    <h1 class="text-center">{!! $titulo !!}</h1>
@stop
@section ("contenido")
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        {!! FORM::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'PUT', 'files'=>'true'])
        !!}
        @include('usuarios.Parciales.nuevoYmodificar')
        <div class="btn-action margin-bottom">
            @if (Auth::user()->roles->peso<config('opciones.roles.administrador'))
                <div class="btn-action">
                    <a title="Volver" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                </div>
            @else
                <a title="Volver" href="{{route('usuarios.index')}}" class="pull-left">
                    <i class="glyphicon glyphicon-arrow-left">
                        <div>Volver</div>
                    </i>
                </a>
            @endif
            <button type="submit" title="Guardar" class="pull-right">
                <i class='glyphicon glyphicon-floppy-disk full-Width'>
                    <div>Guardar</div>
                </i>
            </button>
        </div>
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
    {!! HTML::script('js/comun/foto.js') !!}
@endsection


