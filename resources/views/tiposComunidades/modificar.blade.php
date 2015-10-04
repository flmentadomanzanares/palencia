@extends('plantillas.admin')
@section('titulo')
    {!! $titulo !!}
@endsection
@section('contenido')
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        {!! FORM::model($tipos_comunidades, ['route' => ['tiposComunidades.update', $tipos_comunidades->id], 'method' => 'patch']) !!}
        @include('tiposComunidades.parciales.nuevoYmodificar')
        <div class="btn-action">
            <a title="Volver" href="{{route('tiposComunidades.index')}}" class="pull-left">
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