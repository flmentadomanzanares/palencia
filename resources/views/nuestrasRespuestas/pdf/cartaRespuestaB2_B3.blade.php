<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>palenciaDoc-B2_B3</title>
    <style>
        @page {
            margin: 1.2cm;
            size: A4 portrait;
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

        .pagina {
            position: fixed;
            top: 275mm;
            text-align: center;
            background-color: white;
            height: 30px;
            border-top: 1px solid rgb(0, 0, 0);;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            font-size: 12pt;
            line-height: 1.6;
        }

        .saltoPagina {
            position: fixed;
            page-break-before: left;

        }

        .list {
            position: fixed;
        }

        .alineacion {
            text-align: left;
            display: block;
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
    @if (strtolower($comunidadDestinataria->comunicacion_preferida)!="carta") <br/> @endif
    <span>Queridos hermanos:</span>
    <br/>
    <br/>
        <span class="tab">Recibimos vuestra petici&oacute;n de apoyo espiritual para vuestro Cursillos de Cristiandad Nº
            ........ a celebrar desde el ............ de ................................................... del 20.........</span>
    <br/>
    <br/>
    <span class="tab">Esta Iglesia de Canarias ha rogado al Se&ntilde;or en sus Ultreyas, Reuniones de Grupo y oraciones
        personales por el &eacute;xito espiritual y apost&oacute;lico de ese Cursillo.</span>
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
    <?php $pagina = 0 ?>
    @if(strtolower($comunidadDestinataria->comunicacion_preferida)=="carta")
        <div class="listado"><strong class="subrayado">CURSILLOS POR LOS QUE ORAR&Aacute; NUESTRA COMUNIDAD</strong>
        </div>
        <?php $i = 0?>
        @foreach($cursosPorComunidad as $index=>$curso)
            @if($index>0 && $i==$listadoTotal)<?php $listadoTotal = $listadoTotalRestoPagina;$listadoPosicionInicial = 0;$i = 0; ?>
            <div class="pagina">Pg {{$pagina=$pagina +1}}</div>
            <div class="saltoPagina"></div>@endif
            <div class="list"
                 style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">{{ sprintf("Nº %'06s de fecha %10s al %10s", $curso->num_cursillo, date('d/m/Y', strtotime($curso->fecha_inicio)), date('d/m/Y', strtotime($curso->fecha_final))) }}</div>
            <?php $i++?>
        @endforeach
    @endif
</div>
@include("pdf.Template.carta.footerRespuesta")
<?php if ($pagina > 0) echo '<div class="pagina">Pg ' . ($pagina += 1) . '</div>' ?>
</body>

