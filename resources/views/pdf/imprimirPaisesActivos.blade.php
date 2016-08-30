<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Secretariados por pa&iacute;s</title>

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
            width: 138mm;
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
            width: 50mm;
            border: 1px solid #4a4949;
            margin-left: 530px;
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

        .listIzda {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            height: 30px;
            width: 138mm;
            /*border-bottom: 1px solid #4a4949;*/
            vertical-align: -15px;
            float: left;
        }

        .listDcha {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            height: 30px;
            width: 50mm;
            /*border-bottom: 1px solid #4a4949;*/
            vertical-align: -15px;
            margin-left: 530px;
        }

        .total {
            color: #000000;
            position: fixed;
            text-align: center;
            line-height: 1.6em;
            font-weight: bold;
            height: 30px;
            min-width: 190mm;
            border: 1px solid #4a4949;

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
    $totalPaises = 0;
    $totalComunidades = 0;
    $totalComunidadesPais = 0;

    ?>

    <div class=" cabecera1 text-center">

        {{ $titulo }}<br/>

    </div>

    <div class=" cabecera2">
        Fecha: {{ $date }}
    </div>

    @if(!$comunidades->isEmpty())

        <div class="cabeceraIzda" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
            Pa&iacute;s
        </div>
        <div class="cabeceraDcha" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
            Total Secretariados
        </div>
        <?php $i++?>
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

                @if($totalComunidadesPais != 0)
                    <div class="listDcha" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                        {{$totalComunidadesPais}}
                    </div>
                    <?php $totalComunidadesPais = 0?>
                @endif

                <?php $i++?>

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

                <div class="listIzda" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                    {!! $comunidad->pais!!}
                </div>
                <?php $totalPaises++?>

                <?php $pais = $comunidad->pais; ?>

                <?php $totalComunidadesPais++?>
                <?php $totalComunidades++?>
            @else

                <?php $totalComunidadesPais++?>
                <?php $totalComunidades++?>
            @endif

        @endforeach

        @if($totalComunidadesPais != 0)

            <div class="listDcha" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">
                {{$totalComunidadesPais}}
            </div>
            <?php $totalComunidadesPais = 0?>
        @endif

        <?php $i++?>
        <?php $i++?>

        @if($i>=$saltoPagina)
            <?php
            $lineasPorPagina = $listadoTotalRestoPagina;
            $saltoPagina = $lineasPorPagina - 3;
            $listadoPosicionInicial = 0;
            $i = 0;
            ?>
            <div class="pagina">Pag. {{$pagina += 1}}</div>
            <div class="saltoPagina"></div>
        @endif

        <div class="total" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">Total
            Paises......... {{$totalPaises}} </div>
        <?php $i++?>

        <div class="total" style="top:{{($listadoPosicionInicial + ($i*$separacionLinea))}}em">Total
            Secretariados......... {{$totalComunidades}} </div>
        <?php $i++?>
        <?php if ($pagina > 0) echo '<div class="pagina">P&aacute;g. ' . ($pagina = $pagina + 1) . '</div>' ?>

    @else

        <div class="cabecera3">
            <p>¡Aviso! - No se ha encontrado ningun pa&iacute;s activo que listar.</p>
        </div>

    @endif

</div>

</body>
</html>