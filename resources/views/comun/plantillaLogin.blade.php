<div id="registro" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="100"
             data-modal_plano_z="3"
             data-modal_ancho="275"
             data-etiqueta_ancho="80">
            <span title="Entrar en la aplicaci&oacute;n">
                <i class="glyphicon glyphicon-log-in text-center">
                    <div>Entrar</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!! FORM::open(array('url' => 'auth/login')) !!}
                {!! FORM::label('email', 'Email') !!}
                {!! FORM::text ('email','',array("placeholder"=>"Email de usuario",
                "class"=>"form-control")) !!}
                {!! FORM::label ('password', 'Contrase&ntilde;a') !!}
                {!! FORM::password ('password',array("class"=>"form-control","placeholder"=>"Contrase&ntilde;a"))
                !!}
                <br/>
                {!! FORM::submit('Entrar',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>