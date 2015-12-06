<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>palenciaDoc-A2_A3</title>
    <style>
        body, html {
            font-family: Calibri;
        }

        .logo {
            position: absolute;
            top: -24px;
            right: 0;
            width: 64px;
            height: auto;
        }

        .remitente {
            position: absolute;
            top: 3em;
            left: 0;
            width: 20em;
            text-align: left;
            font-size: 13pt;
            overflow: hidden;
        }

        .fecha_emision {
            position: absolute;
            top: 3em;
            right: 0;
            font-size: 12pt;
        }

        .destinatario {
            position: absolute;
            top: 6em;
            right: 0;
            width: 20em;
            font-size: 12pt;
            overflow: hidden;
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
            top: 15em;
            left: 0;
            font-size: 12pt;
            line-height: 1.6em;
        }

        .firma {
            display: block;
            width: 100%;
            text-align: right;
            font-size: 13pt;
            font-weight: bold;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            font-size: 12pt;
            line-height: 1.6em;
        }

        .naranja {
            color: rgb(220, 100, 1);
        }

        .verde {
            color: rgb(50, 180, 1);
        }

        .rojo {
            color: rgb(252, 59, 0);
        }

        .celeste {
            color: rgb(5, 100, 255);
        }

        .rosa-palo {
            color: rgb(130, 100, 50);
        }

        .amarillo {
            color: rgb(220, 150, 1);
        }

        .lila {
            color: rgb(177, 100, 251);
        }

        .turquesa {
            color: rgb(0, 100, 189);
        }

        .violeta {
            color: rgb(249, 17, 200);
        }
    </style>
</head>
<body>

<div style="width:100%;text-align: right">
    <img class="logo" src={!!asset('img/logo/logo.png')!!} alt=""/>
</div>
<div class="remitente">
    CURSILLOS DE CRISTIANDAD
    <br/>
    DE LA DIÓCESIS DE CANARIAS<br/>
    @if(strlen($remitente->direccion_postal)>0){{$remitente->direccion_postal}}<br/>@endif
    @if(strlen($remitente->direccion)){{$remitente->direccion}}<br/>@endif
    {{$remitente->cp}} {{$remitente->localidad}}@if(strlen($remitente->pais)>0)-{{$remitente->pais}} @endif
</div>

<div class="fecha_emision">
    {{$remitente->localidad}},{{$fecha_emision}}
</div>
<div class="destinatario">
    @if(strlen($destinatario->comunidad)>0){{$destinatario->comunidad}}<br/>@endif
        @if(strlen($destinatario->direccion)>0){{$destinatario->direccion}}<br/>@endif
        @if(strlen($destinatario->cp)>0){{$destinatario->cp}} @endif
        @if(strlen($destinatario->localidad)>0)-{{$destinatario->localidad}} @endif
        @if(strlen($destinatario->cp)>0 || strlen($destinatario->localidad)>0)<br/> @endif
        @if(strlen($destinatario->provincia)>0){{$destinatario->provincia}}
            @if(strlen($destinatario->pais)>0)-{{$destinatario->pais}}@endif
        @endif
</div>
<div class="mensaje">
    @if (!$esCarta) <br/> @endif
    <span>Queridos hermanos:</span>
    <br/>
        <span class="tab">Necesitamos vuestra intendencia para los Cursillos de nuestra Diócesis de
            Canarias-Islas Canarias, España, que más abajo detallamos. Quedamos a vuestra disposición para orar
            también nosotros por los Cursillos que Uds. puedan celebrar, para lo cual pueden enviarnos sus mensajes a
            las direcciones mencionadas más abajo.</span>
    <br/>

    <span class="tab">Desde nuestra Iglesia de Canarias, unidos en la Comunión de los Santos, reciban nuestro
        agradecimiento y nuestros mejores deseos por el éxito espiritual y apostólico de esa Comunidad.</span>
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
        <span class="subrayado"><strong>CURSILLOS PARA LOS QUE NECESITAMOS INTENDENCIA</strong></span>
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
        <span>Dirección para sus solicitudes:<span class="email"> {{$remitente->email_solicitud}}</span></span>
        <br/>
        <span>Dirección para sus envíos:<span class="email"> {{$remitente->email_envio}}</span></span>
        <br/>
    <span>Dirección para pedir por carta: {{$remitente->direccion_postal}} {{$remitente->cp}} {{$remitente->localidad}}
        -{{$remitente->pais}}</span>
    </div>
@endif
</body>
</html>
