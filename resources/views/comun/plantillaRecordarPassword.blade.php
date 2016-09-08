<div id="recordar" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="200"
             data-modal_plano_z="1"
             data-modal_ancho="240"
             data-etiqueta_ancho="80">
            <span title="Nueva alta">
                <i class="glyphicon glyphicon-question-sign text-center">
                    <div>Contrase&ntilde;a</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!! FORM::open(array('url' => '/password/email','method'=>'post')) !!}
                {!! FORM::label ('email', 'Email de env&iacute;o') !!} <br/>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                <br/>
                {!! FORM::submit('Recuperar contrase&ntilde;a',array("class"=>"btn btn-success btn-block actionOkClick")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>