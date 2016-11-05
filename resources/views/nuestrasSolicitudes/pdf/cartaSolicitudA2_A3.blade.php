<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>palenciaDoc-A2_A3</title>
    <style>
        @page {
            margin: 1.2cm;
        }

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
            top: 0;
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
            top: 7.2em;
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
            top: 19em;
            left: 0;
            font-size: 12pt;
            line-height: 1.5em;
        }

        .firma {
            display: block;
            width: 100%;
            text-align: right;
            font-size: 13pt;
            font-weight: bold;
        }

        .alineacion {
            text-align: left;
            display: block;
        }

        .pagina {
            position: fixed;
            top: 275mm;
            text-align: center;
            background-color: white;
            height: 30px;
            border-top: 1px solid rgb(0, 0, 0);
        }

        .saltoPagina {
            position: fixed;
            page-break-before: left;

        }

        .list {
            position: fixed;
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
@include("pdf.Template.carta.header")
<div class="mensaje">
    <span>Queridos hermanos:</span>
    <br/>
    <br/>
        <span class="tab">Necesitamos vuestra intendencia para los Cursillos de nuestra Di&oacute;cesis de
            Canarias-Islas Canarias, Espa&ntilde;a, que m&aacute;s abajo detallamos. Quedamos a vuestra disposici&oacute;n para orar
            tambi&eacute;n nosotros por los Cursillos que Uds. puedan celebrar, para lo cual pueden enviarnos sus mensajes a
            las direcciones mencionadas m&aacute;s abajo.</span>
    <br/>
    <br/>
    <span class="tab">Desde nuestra Iglesia de Canarias, unidos en la Comuni&oacute;n de los Santos, reciban nuestro
        agradecimiento y nuestros mejores deseos por el &eacute;xito espiritual y apost&oacute;lico de esa Comunidad.</span>
    <br/>
    <br/>
    <span class="tab">Que la Gracia del Se&ntilde;or les acompa&ntilde;e siempre. Les abrazamos en Cristo.</span>
    <br/>
    <br/>
    <span class="tab">{{$remitente->localidad}},&nbsp;{{$fecha_emision}}</span>
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
    </span>
    <br>
    <div class="listado"><strong class="subrayado">CURSILLOS PARA LOS QUE NECESITAMOS INTENDENCIA</strong></div>
    <?php $i = 0?>
    <?php $pagina = 0 ?>
    @foreach($cursos as $index=>$curso)
        @if($index>0 && $i==$listadoTotal)<?php $listadoTotal = $listadoTotalRestoPagina;$listadoPosicionInicial = 0;$i = 0; ?>
        <div class="pagina">Pg {{$pagina+= 1}}</div>
        <div class="saltoPagina"></div>@endif
        <div class="list" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">{{ $curso }}</div>
        <?php $i++?>
    @endforeach

</div>
@include("pdf.Template.carta.footer")
<?php if ($pagina > 0) echo '<div class="pagina">Pg ' . ($pagina += 1) . '</div>' ?>
</body>