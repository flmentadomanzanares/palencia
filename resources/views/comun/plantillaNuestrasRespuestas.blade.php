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
             data-modal_ancho="275">
            <div title="Filtros" class="text-center">
                <i class="glyphicon glyphicon-filter text-center"></i>
                <div>Enviar</div>
            </div>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                <div class="form-group">
                    {!! FORM::label('modalidad', 'Medio de comunicaci&oacute;n') !!}
                    {!! FORM::select('modalidad', $tipos_comunicaciones_preferidas, null,array("class"=>"form-control",'id'=>'select_comunicacion'))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('anyo', 'A&ntilde;o Cursillos') !!}
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('respuestasAnteriores', 'Incluir Respuestas Anteriores') !!}
                    {!! FORM::select('incluirRespuestasAnteriores', Array('0'=>'No','1'=>'Si'), null,array("class"=>"form-control",'id'=>'select_boolean'))!!}
                </div>
                <button class=" txt-left btn btn-primary m-b-10 full-Width marcarTodos" type="button"
                        title="Marcar todos los cursillos">
                    <i class='glyphicon  glyphicon-check'></i>
                    Marcar todos los cursillos
                </button>
                <button class=" txt-left btn btn-warning m-b-10 full-Width desmarcarTodos" type="button"
                        title="Desmarcar todos los cursillos">
                    <i class='glyphicon glyphicon-unchecked'></i>
                    Desmarcar todos los cursillos
                </button>
                <div data-role="contenedor_imputs">
                    <div data-role="destinatarios"></div>
                    {!!FORM::model(Request::only(['nuestrasComunidades'])
                   ,['route'=>'comprobarNuestrasRespuestas'
                   ,'method'=>'POST'
                   ,'name'=>'formularioNuestrasRespuestas'
                   ,'data-role'=>'conVerificado']) !!}
                    <div class="form-group">
                        {!! FORM::label('remitente', 'Comunidad Remitente') !!}
                        {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control","id"=>"select_comunidad_propia"))!!}
                    </div>
                    <div data-role="cursillos"></div>
                    {!! FORM::submit('Enviar',array("class"=>"btn btn-success btn-block")) !!}
                    {!! FORM::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>