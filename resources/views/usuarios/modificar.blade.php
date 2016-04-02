@extends ("plantillas.admin")

@section ("titulo")
    <h1 class="text-center">{!! $titulo !!}</h1>
@stop
@section ("contenido")
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'PUT', 'files'=>'true'])!!}
        @include('usuarios.Parciales.nuevoYmodificar')
        @include('comun.plantillaVolverModificarGuardar',['index'=>(Auth::user()->roles->peso<config('opciones.roles.administrador'))?'inicio': 'usuarios.index' ,'accion'=>"Guardar"])
        {!! FORM::close() !!}
    </div>
@endsection
@section("css")
@stop
@section('js')
    {!! HTML::script('js/comun/foto.js') !!}
@endsection


