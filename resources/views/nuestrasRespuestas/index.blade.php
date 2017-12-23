@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima">
        @if (Auth::check())
            @include('comun.plantillaNuestrasRespuestas')
            <div data-role="modalMensaje">
                <span
                        class="pull-right simpleModal"
                        data-modal_centro_pantalla="true"
                        data-modal_en_la_derecha="false"
                        data-modal_sin_etiqueta="true"
                        data-modal_ancho="330"
                        data-modal_cabecera_color_fondo='rgba(255,0,0,.9)'
                        data-modal_cabecera_color_texto='#ffffff'
                        data-modal_cuerpo_color_fondo='rgba(255,255,255,1)'
                        data-modal_cuerpo_color_texto='"#ffffff'
                        data-modal_pie_color_fondo='#400090'
                        data-modal_pie_color_texto='"#ffffff'
                        data-modal_posicion_vertical="220"
                        data-titulo="VERIFICADO"
                        data-pie="false"
                        data-descripcion=""
                >
                </span>
                @include ("comun.plantillaMensaje")
            </div>
            <div class="heading-caption">Enviar</div>
            <div data-role="lista_cursillos"></div>
            <hr>
            <div class="heading-caption">Comunidades Destinatarias</div>
            <div data-role="comunidades_destinatarias"></div>
            <div data-role="seleccion_destinatarios" class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
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
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    @if (Auth::check())
        {!! HTML::script('js/comun/nuestrasRespuestas.js') !!}
    @endif
@endsection
