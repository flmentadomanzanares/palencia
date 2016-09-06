<div id="registro" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="lanzarModal simpleModal"
             data-etiqueta_color_fondo="rgba(76, 158, 217,.8)"
             data-etiqueta_color_texto="rgba(255,255,255,1)"
             data-modal_posicion_vertical="150"
             data-modal_plano_z="2"
             data-modal_ancho="275"
             data-etiqueta_ancho="80">
            <span title="Nueva alta">
                <i class="glyphicon glyphicon-plus-sign text-center">
                    <div>Alta</div>
                </i>
            </span>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!! FORM::open(array('url' => 'auth/register')) !!}
                {!! FORM::label('fullname', 'Nombre completo') !!}
                {!! FORM::text ('fullname',"",array("class"=>"form-control")) !!}
                {!! FORM::label('username', 'Nombre usuario') !!}
                {!! FORM::text ('name',"",array("maxlength"=>"20","class"=>"form-control")) !!}
                {!! FORM::label ('email', 'Email') !!}
                {!! FORM::text('email',"",array("class"=>"form-control")) !!}
                {!! FORM::label ('password', 'Contrase&ntilde;a') !!}
                {!! FORM::password ('password',array("class"=>"form-control")) !!}
                {!! FORM::label ('passwordConfrmation', 'Repetir contrase&ntilde;a') !!}
                {!! FORM::password ('password_confirmation',array("class"=>"form-control")) !!}
                <br/>
                {!! FORM::submit('Registrarse',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>