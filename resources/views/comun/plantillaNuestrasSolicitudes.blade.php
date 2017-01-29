<div class="formularioModal">
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
            <span title="Filtros" class="text-center">
                <i class="glyphicon glyphicon-filter text-center">
                    <div>Cursos</div>
                </i>
            </span>
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
                {!!FORM::model(Request::only(['modalidad','nuestrasComunidades','tipos_comunicaciones_preferidas','anyos']),['route'=>'comprobarNuestrasSolicitudes','method'=>'POST','name'=>'formularioNuestrasSolicitudes','data-role'=>'conVerificado']) !!}
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
                <div class="form-group">
                    {!! FORM::label('remitente', 'Comunidad Remitente') !!}
                    {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control",'id'=>'select_comunidad_propia'))!!}
                </div>
                <div class="form-group">
                    <div class="col-md-1 col-sm-1 col-lg-1 col-xs-1 p-v-5">
                        {!! FORM::checkbox('incluirEnSusRespuestas', 1, false, array("class"=>"lg","id"=>"incluirEnSusRespuestas")) !!}
                    </div>
                    <div class="col-md-11 col-sm-11 col-lg-11 col-xs-11 p-h-5">
                        {!! FORM::label('incluirEnSusRespuestas', 'No enviar, sólo incluir solicitudes pendientes de respuesta',array("for"=>"incluirEnSusRespuestas")) !!}
                    </div>
                </div>
                <div data-role="contenedor_imputs">
                    <div data-role="cursillos"></div>
                    <div data-role="destinatarios"></div>
                </div>
                {!! FORM::submit('Enviar',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>i