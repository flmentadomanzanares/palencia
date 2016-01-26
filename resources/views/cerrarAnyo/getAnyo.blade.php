@extends('plantillas.admin')

@section('titulo')
    <h1 class="text-center">{!! $titulo !!}</h1>
@endsection
@section('contenido')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="hidden table-size-optima altoMaximo">
        @if (Auth::check())
            <div class="row ">
                {!! FORM::open(['route'=>'borrarTablas','method'=>'POST']) !!}
                <div class="alert alert-danger" role="alert">
                    ¡¡AVISO!!: Al pulsar "Borrar" se borraran todos los registros de cursillos y solicitudes del año seleccionado.
                </div>
                <div class="heading-caption">Seleccione año a cerrar ...</div>
                {!! FORM::label('anyo', 'Año') !!} <br/>
                {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                <br/>

                <div class="btn-action margin-bottom">
                    <a title="Inicio" href="{{route('inicio')}}" class="pull-left">
                        <i class="glyphicon glyphicon-home">
                            <div>Inicio</div>
                        </i>
                    </a>
                    <button type="button" id="delete" class="pull-right" data-toggle="modal" data-target="#myModal">
                        <i class='glyphicon glyphicon-trash full-Width'>
                            <div>Borrar</div>
                        </i>
                    </button>

                </div>
                <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Borrar cursillos y sus solicitudes</h4>
                            </div>
                            <div class="modal-body">
                                <p>¿Esta seguro que quiere borrar los cursillos y sus solicitudes?</p>
                                <p>Una vez borrados no se podran recuperar.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">¡No!, quiero volver atras</button>
                                <button type="submit" class="btn btn-danger borrado">¡Si!, quiero borrarlos</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                {!! FORM::close() !!}
            </div>

        @else
            @include('comun.guestGoHome')
        @endif
    </div>
@endsection
@section('js')
    {!! HTML::script('js/comun/semanasSolicitudesRecibidasCursillos.js') !!}
    {!! HTML::script('js/comun/confirmacionBorrar.js') !!}
@endsection
