@extends('plantillas.admin')
@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="spinner"></div>
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!!FORM::model(Request::only(['modalidad','nuestrasComunidades','restoComunidades','cursillo','tipos_comunicaciones_preferidas','anyos']),['route'=>'comprobarNuestrasSolicitudes','method'=>'POST']) !!}
                <div class="heading-caption">Modalidad envío</div>
                {!! FORM::select('modalidad', $tipos_comunicaciones_preferidas, null,array("class"=>"form-control"))!!}
                <br/>

                <div class="heading-caption">Remitente</div>
                {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control",'id'=>'select_comunidad'))!!}
                <br/>

                <div class="heading-caption">Año Cursillos</div>
                {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                <br/>

                <div class="heading-caption">Excluir Solicitudes Anteriores</div>
                {!! FORM::select('incluirSolicitudesAnteriores', Array('1'=>'Si','0'=>'No'), null,array("class"=>"form-control",'id'=>'select_boolean'))!!}
                <br/>

                <div class="heading-caption">Destinatario/s</div>
                {!! FORM::select('restoComunidades', $restoComunidades, null,array("class"=>"form-control"))!!}
                <br/>

                <div class="heading-caption">Cursillos</div>
                <div id="listado_cursillos" class="text-left" style="max-height:250px;overflow-y: auto "></div>
                <br/>

                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="submit" title="Enviar" class="pull-right">
                        <i class='glyphicon glyphicon-envelope full-Width'>
                            <div>Enviar</div>
                        </i>
                    </button>
                </div>
                {!! FORM::close() !!}
            </div>
        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/nuestrasSolicitudes.js') !!}
@endsection
