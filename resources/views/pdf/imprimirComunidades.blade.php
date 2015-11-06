<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Intendencia para Clausura</title>
    {!! HTML::style('css/pdf.css') !!}
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="text-center">
    <div class="cabecera1 text-center">
        {{ $titulo }}
    </div>
    <div class="cabecera2">
        Cursillo: {!! $cursillo->cursillo !!}<br/>
        Año: {{ $anyo }}
    </div>
</div>

<div class="cabecera2">
    Fecha: {{ $date }}
</div>

@if(!$comunidades->isEmpty())

<table border="0" cellspacing="0" cellpadding="0">
    <?php $pais = null; ?>
    <?php $comunidad = null; ?>

        <thead>

        </thead>
        <tbody>

        @foreach ($comunidades as $comunidad)

            @if($comunidad->pais != $pais)
                <tr>
                    <th class="cabecera3 text-center">
                        País: {!! $comunidad->pais !!}

                    </th>
                </tr>

                <?php $pais = $comunidad->pais; ?>
            @endif

                <tr>
                    <th >
                        {!! $comunidad->comunidad !!}
                    </th>
                </tr>
        @endforeach

        </tbody>
</table>
@else
    <div>
        <div class="cabecera4 text-center">
            <p>¡Aviso! - No se ha encontrado ninguna comunidad que listar para el cursillo solicitado.</p>
        </div>
    </div>
@endif
</body>
</html>