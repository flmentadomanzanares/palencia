@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($tipos_comunicaciones_preferidas, ['route' => ['tiposComunicacionesPreferidas.update', $tipos_comunicaciones_preferidas->id], 'method' => 'patch']) !!}
        @include('tiposComunicacionesPreferidas.parciales.nuevoYmodificar')
        <div class="btn-action margin-bottom">
            <a title="Volver" href="{{route('tiposComunicacionesPreferidas.index')}}" class="pull-left">
                <i class="glyphicon glyphicon-arrow-left">
                    <div>Volver</div>
                </i>
            </a>
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
@endsection