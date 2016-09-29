<div id="nuestrasRespuestas" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_ancho="80"
             data-etiqueta_color_fondo="rgba(201, 108, 249,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_cuerpo_color_fondo="rgba(255,255,255,.9)"
             data-modal_cuerpo_color_texto="#400090"
             data-modal_posicion_vertical="100"
             data-modal_plano_z="2"
             data-modal_ancho="320">
            <span title="Filtros" class="text-center">
                <i class="glyphicon glyphicon-filter text-center">
                    <div>Filtros</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['nuestrasComunidades','restoComunidades']),['route'=>'enviarRespuestasSinSolicitudes','method'=>'POST', 'name'=>'formularioRespuestasSinSolicitudes']) !!}
                {!! FORM::hidden('esSolicitudAnterior', true) !!}
                <div class="form-group">
                    {!! FORM::label('remitente', 'Nuestra Comunidad') !!}
                    {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control","id"=>"select_comunidad_propia"))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('anyo', 'A&ntilde;o Cursillos') !!}
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('destinatario', 'Comunidad Destinataria') !!}
                    {!! FORM::select('restoComunidades', $restoComunidades, null,array("class"=>"form-control",'id'=>'select_comunidad_no_propia'))!!}
                </div>
                <button class=" txt-left btn btn-primary m-b-10 full-Width marcarTodos" type="button"
                        title="Marcar todos">
                    <i class='glyphicon  glyphicon-check'></i>
                    Marcar todas
                </button>
                <button class=" txt-left btn btn-warning m-b-10 full-Width desmarcarTodos" type="button"
                        title="Desmarcar todos">
                    <i class='glyphicon glyphicon-unchecked'></i>
                    Desmarcar todas
                </button>
                <br/>
                <div class="contenedor"></div>
                {!! FORM::submit('Responder',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>
