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
             data-modal_ancho="320">
            <span title="Filtros" class="text-center">
                <i class="glyphicon glyphicon-filter text-center">
                    <div>Filtros</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!!FORM::model(Request::only(['modalidad','nuestrasComunidades','restoComunidades','tipos_comunicaciones_preferidas','anyos']),['route'=>'comprobarNuestrasSolicitudes','method'=>'POST']) !!}
                <div class="form-group">
                    {!! FORM::label('modalidad', 'Medio de comunicaci&oacute;n') !!}
                    {!! FORM::select('modalidad', $tipos_comunicaciones_preferidas, null,array("class"=>"form-control",'id'=>'select_comunicacion'))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('remitente', 'Comunidad Remitente') !!}
                    {!! FORM::select('nuestrasComunidades', $nuestrasComunidades, null,array("class"=>"form-control",'id'=>'select_comunidad'))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('anyo', 'A&ntilde;o Cursillos') !!}
                    {!! FORM::select('anyo', $anyos, null,array("class"=>"form-control",'id'=>'select_anyos'))!!}
                </div>

                <div class="form-group">
                    {!! FORM::label('solicitudesAnteriores', 'Incluir Solicitudes Anteriores') !!}
                    {!! FORM::select('incluirSolicitudesAnteriores', Array('1'=>'Si','0'=>'No'), 0,array("class"=>"form-control",'id'=>'select_boolean'))!!}
                </div>

                @if(config("opciones.accion.crearSusRespuestasConSolicitudesAnterioresRealizadas"))
                    <div class="form-group">
                        {!! FORM::label('generearSusRespuestas', 'Generar Sus Respuestas') !!}
                        {!! FORM::select('generarSusRespuestas', Array('0'=>'No','1'=>'Si'), 0,array("class"=>"form-control",'id'=>'select_generar_sus_respuestas'))!!}
                    </div>
                @endif
                <div class="form-group">
                    {!! FORM::label('restosComunidades', 'Comunidades Destinatarias') !!}
                    {!! FORM::select('restoComunidades', $restoComunidades, null,array("class"=>"form-control",'id'=>'select_resto_comunidades'))!!}
                </div>
                <br/>
                {!! FORM::submit('Enviar',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>
