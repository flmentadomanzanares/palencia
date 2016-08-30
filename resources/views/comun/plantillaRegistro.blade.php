<div id="registro" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="cabeceraFormularioModal">
            <span></span>

            <div title="Cerrar" class="closeFormModal">X</div>
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
                {!! FORM::label ('password', 'Contraseña') !!}
                {!! FORM::password ('password',array("class"=>"form-control")) !!}
                {!! FORM::label ('passwordConfrmation', 'Repetir contraseña') !!}
                {!! FORM::password ('password_confirmation',array("class"=>"form-control")) !!}
                <br/>
                {!! FORM::submit('Registrarse',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>