<div id="registro" class="formularioModal">
    <div class="ventanaModal">
        <div class="headerFormularioModal">
            <span></span>

            <div title="Cerrar" class="closeFormModal">X</div>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!! FORM::open(array('url' => 'auth/register')) !!}
                {!! FORM::label('fullname', 'nombre completo') !!}
                {!! FORM::text ('fullname',"",array("class"=>"form-control")) !!}
                {!! FORM::label('username', 'nombre usuario') !!}
                {!! FORM::text ('name',"",array("maxlength"=>"20","class"=>"form-control")) !!}
                {!! FORM::label ('email', 'email') !!}
                {!! FORM::text('email',"",array("class"=>"form-control")) !!}
                {!! FORM::label ('password', 'contraseña') !!}
                {!! FORM::password ('password',array("class"=>"form-control")) !!}
                {!! FORM::label ('passwordConfrmation', 'repetir contraseña') !!}
                {!! FORM::password ('password_confirmation',array("class"=>"form-control")) !!}
                <br/>
                {!! FORM::submit('registrarse',array("class"=>"btn btn-success btn-block")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>