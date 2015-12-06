<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cursillos en el Mundo</title>
    <link media="all" type="text/css" rel="stylesheet" href="{!!asset("css/pdf.css") !!}"/>
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="text-center">
    <div class="cabecera1">
        {{ $titulo }}
    </div>

    <div class="cabecera2">
    @if ($anyo == 0)
            <br/>
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