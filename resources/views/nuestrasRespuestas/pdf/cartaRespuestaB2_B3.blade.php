<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>palenciaDoc-B3</title>
    <style>
        body, html {
            font-family: Calibri;
        }

        .logo {
            position: absolute;
            top: 0;
            right: 0;
            width: 64px;
            height: auto;
        }

        .remitente {
            position: absolute;
            top: 0em;
            left: 0;
            width: 28em;
            text-align: center;
            font-size: 12pt;
        }

        .fecha_emision {
            position: absolute;
            top: 6em;
            right: 0;
            font-size: 10pt;
        }

        .destinatario {
            position: absolute;
            top: 8em;
            right: 0;
            width: 25em;
            font-size: 10pt;
        }

        .tab {
            padding-left: 2em;
        }

        .subrayado {
            text-decoration: underline;
        }

        .email {
            text-decoration: underline;
            font-weight: bold;
            font-style: italic;
            color: blue;
        }

        .mensaje {
            position: absolute;
            top: 25em;
            left: 0;
            font-size: 10pt;
            line-height: 1.6em;
        }

        .firma {
            display: block;
            width: 100%;
            text-align: right;
            font-size: 12pt;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            font-size: 10pt;
            line-height: 1.6em;
        }

        .naranja {
            color: rgb(255, 170, 1);
        }

        .verde {
            color: rgb(101, 199, 88);
        }

        .rojo {
            color: rgb(252, 59, 0);
        }

        .celeste {
            color: rgb(5, 232, 251);
        }

        .rosa-palo {
            color: rgb(226, 165, 173);
        }

        .amarillo {
            color: rgb(252, 241, 3);
        }

        .lila {
            color: rgb(177, 156, 251);
        }

        .turquesa {
            color: rgb(0, 173, 189);
        }

        .violeta {
            color: rgb(249, 17, 253);
        }
    </style>
</head>
<body>

<div style="width:100%;text-align: right">
    <img class="logo" src={!!asset('img/logo/logo.png')!!} alt=""/>
</div>
<div class="remitente">
    CURSILLOS DE CRISTIANIDAD - DIÓCESIS DE CANARIAS<br/>
    {{$remitente->direccion_postal}}<br/>
    {{$remitente->direccion}}<br/>
    {{$remitente->cp}} {{$remitente->localidad}}-{{$remitente->pais}}
</div>

    <div class="fecha_emision">
        {{$remitente->localidad}},{{$fecha_emision}}
    </div>
    <div class="destinatario">
        {{$destinatario->comunidad}}
        <br/>
        {{$destinatario->direccion}}
        <br/>
        {{$destinatario->cp}}-{{$destinatario->localidad}}
        <br/>
        {{$destinatario->provincia}}-{{$destinatario->pais}}
    </div>

<div class="mensaje">
    @if (!$esCarta) <br/> @endif
    <span>Queridos hermanos:</span>
    <br/>
        <span class="tab">Recibimos vuestra petición de apoyo espiritual para vuestro Cursillos de Cristiandad <strong>Nº
       ........</strong> a celebrar desde el <strong>..........</strong> de <strong>................................</strong> del 20<strong>.........</strong></span>
    <br/>

    <span class="tab">Esta Iglesia de Canarias ha rogado al Señor en sus Ultreyas, Reuniones de Grupo y oraciones
        personales por el éxito espiritual y apostólico de ese Cursillo</span>
    <br/>
    <br/>
    <span class="tab">Que la Gracia del Señor les acompañe siempre. Les abrazamos en Cristo.</span>
    <br/>
    <br/>
    <span class="firma">
        ¡
        <span class="naranja">D</span>
        <span class="verde">E</span>
        <span class=""> </span>
        <span class="rojo">C</span>
        <span class="celeste">O</span>
        <span class="rosa-palo">L</span>
        <span class="amarillo">O</span>
        <span class="lila">R</span>
        <span class="turquesa">E</span>
        <span class="violeta">S</span>
        !
    </span><br>
    @if($esCarta)
        <span class="subrayado"><strong>CURSILLOS POR LOS QUE ORARÁ NUESTRA COMUNIDAD</strong></span>
        <br/>
        <ul>
            @foreach($cursos as $curso)
                <li class="tab">{{ $curso }}</li>
            @endforeach
        </ul>
    @endif
</div>
@if($esCarta)
    <div class="footer">
        <strong>NOTA.</strong><span> Les rogamos rellenen los datos para cada Cursillo en las fotocopias que sean necesarias.</span>
        <br/>
        <span>Dirección para sus solicitudes:<span class="email"> {{$remitente->email_solicitud}}</span></span>
        <br/>
        <span>Dirección para sus envíos:<span class="email"> {{$remitente->email_envio}}</span></span>
        <br/>
    <span>Dirección postal: {{$remitente->direccion_postal}} {{$remitente->cp}} {{$remitente->localidad}}
        -{{$remitente->pais}}</span>
    </div>
@endif
</body>
</html>
