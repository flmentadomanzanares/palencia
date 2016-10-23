@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaNuestrasSolicitudes')
            <div class="heading-caption">Cursillos</div>
            <div data-role="lista_cursillos"></div>
            <hr>
            <div class="heading-caption">Comunidades Destinatarias</div>
            <div data-role="comunidades_destinatarias"></div>
            <div data-role="seleccion_destinatarios" class="panel panel-default panel-body">
                <button data-role="marcarTodos" class="txt-left btn btn-primary m-b-10" type="button"
                        title="A&ntilde;adir todos los destinatarios">
                    <i class='glyphicon  glyphicon-plus-sign'></i>
                    A&ntilde;adir todas
                </button>
                <button data-role="eliminarTodos" class="txt-left btn btn-warning m-b-10" type="button"
                        title="Eliminar todos los destinatarios">
                    <i class='glyphicon glyphicon-remove-sign'></i>
                    Eliminar todas
                </button>
                <button data-role="ordenar" class="pull-right txt-left btn btn-info m-b-10" type="button"
                        title="Ordenar los destinatarios">
                    <i class='glyphicon  glyphicon-sort-by-alphabet'></i>
                    Ordenar
                </button>
                <div class="form-group">
                    {!! FORM::select('comunidadesDestinatarias', $restoComunidades, null,array("class"=>"form-control",'id'=>'select_resto_comunidades'))!!}
                </div>
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    @if (Auth::check())
        {!! HTML::script('js/comun/nuestrasSolicitudes.js') !!}
    @endif
@endsection
