@if($esCarta)
    <div class="footer">
        <strong>NOTA.</strong><span> Les rogamos rellenen los datos para cada Cursillo en las fotocopias que sean necesarias.</span>
        <br/>
        <span>Dirección para sus solicitudes:<span class="email"> {{$remitente->email_solicitud}}</span></span>
        <br/>
        <span>Dirección para sus envíos:<span class="email"> {{$remitente->email_envio}}</span></span>
        <br/>
        <span>Dirección para pedir por carta: {{$remitente->direccion_postal}}  {{$remitente->localidad}}
            -{{$remitente->pais}}</span>
    </div>
@endif
