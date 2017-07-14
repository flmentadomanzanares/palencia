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
            <div title="Filtros" class="text-center">
                <i class="glyphicon glyphicon-filter text-center"></i>
                <div>Filtros</div>
            </div>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['nuestrasComunidades','restoComunidades'])
                    ,['route'=>'enviarRespuestasSinSolicitudes'
                    ,'method'=>'POST'
                    , 'name'=>'formularioRespuestasSinSolicitudes'
                    ,'data-role'=>'conVerificado'
                    ]) !!}
                <div class="form-group">
                    {!! FORM::label('remitente', 'Nuestra Comunidad') !!}
                    {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control","id"=>"select_comunidad_propia"))!!}
                </div>
                <div class="form-group">
                    {!! FORM::label('anyo', 'A&ntilde;o Cursillos') !!}
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>
                <button class=" txt-left btn btn-primary m-b-10 full-Width marcarTodos" type="button"
                        title="Marcar todos los cursillos">
                    <i class='glyphicon  glyphicon-check'></i>
                    Marcar todos los cursillos
                </button>
                <button class=" txt-left btn btn-warning m-b-10 full-Width desmarcarTodos" type="button"
                        title="Desmarcar todos los cursiliios">
                    <i class='glyphicon glyphicon-unchecked'></i>
                    Desmarcar todos los cursillos
                </button>
                <br/>
                <div data-role="contenedor_imputs">
                    <div data-role="cursillos"></div>
                    <div data-role="destinatarios"></div>
                </div>
                {!! FORM::submit('Responder',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>
