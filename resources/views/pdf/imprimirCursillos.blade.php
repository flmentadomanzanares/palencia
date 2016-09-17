<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cursillos en el Mundo</title>

    <style>

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 19cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        .text-center {

            text-align: center;
        }

        .cabecera1 {

            font-size: 25px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000000;

        }

        .cabecera2 {

            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
            color: #000000;

        }

        .cabecera3 {
            color: #000000;
            font-weight: bold;
            border: 1px solid #4a4949;
            text-align: center;
        }

        .cabecera4 {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            font-weight: bold;
            height: 30px;
            min-width: 190mm;
            border: 1px solid #4a4949;
        }

        .cabeceraIzda {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            font-weight: bold;
            height: 30px;
            width: 25mm;
            border: 1px solid #4a4949;
            float: left;

        }

        .cabeceraDcha {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            font-weight: bold;
            height: 30px;
            width: 163mm;
            border: 1px solid #4a4949;
            margin-left: 104px;
        }

        .contenedor {
            position: absolute;
            top: 0;
            left: 0;
            font-size: 12pt;
            line-height: 1.5em;
        }

        @page {
            margin: 1.2cm;
        }

        .pagina {
            position: fixed;
            top: 265mm;
            text-align: center;
            height: 30px;
            color: #000000;
        }

        .saltoPagina {
            position: fixed;
            page-break-before: left;
        }

        .list {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            height: 30px;
            min-width: 190mm;
            /*border-bottom: 1px solid #4a4949;*/
            vertical-align: -15px;

        }

    </style>
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="contenedor">

    <?php
    $pais = null;
    $comunidad = null;
    $i = 0;
    $pagina = 0;
    $lineasPorPagina = $listadoTotal;
    $saltoPagina = $lineasPorPagina - 4;
    ?>

    <div class="text-center">
        <div class="cabecera1">
            {{ $titulo }}
        </div>

        <div class="cabecera2">
            @if ($anyo == 0)
            </br>
            @elseif($semana == 0)
                A&ntilde;o: {{ $anyo }}
            @else
                Semana: {{ $semana }} - {{ $anyo }}
            @endif
        </div>
    </div>

    <div class="cabecera2">
        Fecha: {{ $date }}
    </div>

    @if(!$cursillos->isEmpty())

        @foreach ($cursillos as $index=>$cursillo)
            @if($index>0 && $i==$lineasPorPagina)
                <?php
                $lineasPorPagina = $listadoTotalRestoPagina;
                $saltoPagina = $lineasPorPagina - 3;
                $listadoPosicionInicial = 0;
                $i = 0;
                ?>
                <div class="pagina">Pag. {{$pagina += 1}}</div>
                <div class="saltoPagina"></div>

            @endif

            @if($cursillo->pais != $pais)

                @if($index>0 && $i>=$saltoPagina)
                    <?php
                    $lineasPorPagina = $listadoTotalRestoPagina;
                    $saltoPagina = $lineasPorPagina - 3;
                    $listadoPosicionInicial = 0;
                    $i = 0;
                    ?>
                    <div class="pagina">Pag. {{$pagina += 1}}</div>
                    <div class="saltoPagina"></div>
                @endif

                <?php $i++?>
                <div class="cabecera4" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                    Pa&iacute;s: {!! $cursillo->pais!!}
                </div>

                <?php $pais = $cursillo->pais; ?>
                <?php $i++?>
                <div class="list" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                    {!! $cursillo->comunidad !!}
                </div>
            @else
                <div class="list" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                    {!! $cursillo->comunidad !!}
                </div>
            @endif

            <?php $i++?>


        @endforeach
        <?php if ($pagina > 0) echo '<div class="pagina">P&aacute;g. ' . ($pagina = $pagina + 1) . '</div>';?>
    @else
        <div class="cabecera3">
            <p>¡Aviso! - No se ha encontrado ningun cursillo que listar.</p>
        </div>
    @endif

</div>

</body>
</html>