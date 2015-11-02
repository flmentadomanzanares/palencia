<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cursillos en el Mundo</title>
    {!! HTML::style('css/pdf.css') !!}
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="text-center">
    <h1>{{ $titulo }}</h1><br/>

    @if ($anyo == 0)
        </br>
    @elseif($semana == 0)
        <h2>Año: {{ $anyo }}</h2>
    @else
        <h2>Semana: {{ $semana }} - {{ $anyo }}</h2>
    @endif
</div>

<h2>Fecha: {{ $date }} </h2><br/>

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
                    <th class="cabecera1 text-center" colspan="2">
                        País: {!! $cursillo->pais !!}

                    </th>
                </tr>

                <?php $pais = $cursillo->pais; ?>
            @endif

            @if($cursillo->comunidad != $comunidad)
                <tr>
                    <th class="cabecera2 text-center" colspan="2">
                        Comunidad: {!! $cursillo->comunidad !!}
                    </th>
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
        <div class="cabecera2 text-center">
            <p>¡Aviso! - No se ha encontrado ningun cursillo que listar.</p>
        </div>
    </div>
@endif
</body>
</html>