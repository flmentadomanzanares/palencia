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
            margin-bottom:20px;
            color:#000000;

        }

        .cabecera2 {

            font-weight: bold;
            font-size: 18px;
            margin-bottom:20px;
            color:#000000;

        }
        .cabecera3 {

           /* background-color: #400090;*/
            color: #000000;
            font-weight: bold;
            font-size: 18px;
            border: 1px solid #4a4949;

        }


        .cabecera4 {

            /*background-color: #FF7A00;*/
            color: #000000;
            font-weight: bold;
            font-size: 18px;
            border: 1px solid #4a4949;

        }

        table thead, table th {
            background-color: #9d9d9d;
            color:#000000;
            font-weight: bold;
            text-align: center;
            padding-top:20px;
            padding-bottom:20px;

        }

        table {
            width: 100%;
            margin-bottom: 20px;

        }


        table td {
            padding: 20px;
            background: #FFFFFF;
            text-align: center;
            border-bottom: 1px solid #4a4949;
            color: #000000;

        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: left;
        }

        .td1 {

            width: 10%;

        }

        .td2 {
            width: 90%;
        }

    </style>
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="text-center">
    <div class="cabecera1">
        {{ $titulo }}
    </div>

    <div class="cabecera2">
    @if ($anyo == 0)
        </br>
    @elseif($semana == 0)
        Año: {{ $anyo }}
    @else
        Semana: {{ $semana }} - {{ $anyo }}
    @endif
    </div>
</div>

<div class="cabecera2">
    Fecha: {{ $date }}
</div>

@if(!$cursillos->isEmpty())

<table border="0" cellspacing="0" cellpadding="0">
    <?php $pais = null; ?>
    <?php $comunidad = null; ?>

        <thead>

        </thead>
        <tbody>

        @foreach ($cursillos as $cursillo)

            @if($cursillo->pais != $pais)
                <tr>
                    <td class="cabecera3 text-center" colspan="2">
                        País: {!! $cursillo->pais !!}

                    </td>
                </tr>

                <?php $pais = $cursillo->pais; ?>
            @endif

            @if($cursillo->comunidad != $comunidad)
                <tr>
                    <td class="cabecera4 text-center" colspan="2">
                        Comunidad: {!! $cursillo->comunidad !!}
                    </td>
                </tr>
                <?php $comunidad = $cursillo->comunidad; ?>
            @endif

            <tr>
                <td class="td1">{!! $cursillo->num_cursillo !!}</td>
                <td class="td2">{!! $cursillo->cursillo !!}</td>
            </tr>
        @endforeach

        </tbody>
</table>
@else
    <div>
        <div class="cabecera4 text-center">
            <p>¡Aviso! - No se ha encontrado ningun cursillo que listar.</p>
        </div>
    </div>
@endif
</body>
</html>