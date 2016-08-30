@if($esCarta)
    <div class="footer">
        {{--<strong>NOTA.</strong><span> Les rogamos rellenen los datos para cada Cursillo en las fotocopias que sean necesarias.</span>
        <br/>--}}
        <span>Direcci&oacute;n para sus solicitudes:<span class="email"> {{$remitente->email_solicitud}}</span></span>
        <br/>
        <span>Direcci&oacute;n para sus env&iacute;os:<span class="email"> {{$remitente->email_envio}}</span></span>
        <br/>
        <span>Direcci&oacute;n para pedir por carta: {{$remitente->direccion_postal}}  {{$remitente->localidad}}
            -{{$remitente->pais}}</span>
    </div>
@endif
