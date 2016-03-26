<div id="recordar" class="formularioModal">
    <div class="modalBackGround"></div>
    <div class="ventanaModal">
        <div class="cabeceraFormularioModal">
            <span></span>
            <a title="Cerrar" class="closeFormModal">X</a>
        </div>
        <div class="cuerpoFormularioModal">
            <div class="scroll">
                {!! FORM::open(array('url' => '/password/email','method'=>'post')) !!}
                {!! FORM::label ('email', 'email de envío') !!} <br/>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                <br/>
                {!! FORM::submit('Reset password',array("class"=>"btn btn-success btn-block actionOkClick")) !!}
                {!! FORM::close() !!}
            </div>
        </div>
    </div>
</div>