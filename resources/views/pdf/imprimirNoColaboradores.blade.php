<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Secretariados por país</title>

    <style>

        @page {
            margin: 1.2cm;
        }

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

        .cabecera5 {
            color: #000000;
            font-weight: bold;
            font-size: 20px;
            padding-top: 20px;
            padding-bottom: 20px;
            border: 1px solid #4a4949;
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
            border-bottom: 1px solid #4a4949;
            vertical-align: -15px;
        }

    </style>
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="contenedor">

    <?php
        $pais = null;
        $i = 0;
        $pagina = 0;
        $lineasPorPagina = $listadoTotal;
        $saltoPagina = $lineasPorPagina - 3;

    ?>

    <div class=" cabecera1 text-center">

        {{ $titulo }}<br/>

    </div>

    <div class=" cabecera2">
        Fecha: {{ $date }}
    </div>

    @if(!$comunidades->isEmpty())

        <div class="cabecera5 text-center">Secretariados</div><br/>

        @foreach ($comunidades as $index=>$comunidad)

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

            @if($comunidad->pais != $pais)

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
                    País: {!! $comunidad->pais!!}
                </div>
                <?php $i++?>
                <?php $pais = $comunidad->pais; ?>
                <?php $i++?>
                <div class="list" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                    {!! $comunidad->comunidad !!}
                </div>
            @else
                <div class="list" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                    {!! $comunidad->comunidad !!}
                </div>
            @endif

            <?php $i++?>

        @endforeach

        <?php if ($pagina > 0) echo '<div class="pagina">P&aacute;g. ' . ($pagina = $pagina + 1) . '</div>' ?>
    @else
        <div class="cabecera3">
            <p>¡Aviso! - No se ha encontrado ningun secretariado que listar para el país solicitado.</p>
        </div>
    @endif

</div>
</body>
</html>