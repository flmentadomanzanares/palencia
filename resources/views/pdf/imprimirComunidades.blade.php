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
    {{--div class="cabecera2">
        Cursillo: {!! $cursillo->cursillo !!}<br/>
        Año: {{ $anyo }}
    </div--}}
</div>

<div class="cabecera2">
    Fecha: {{ $date }}
</div>

@if(!$comunidades->isEmpty())

<table border="0" cellspacing="0" cellpadding="0">
    <?php $pais = null; ?>
    <?php $cursillo = null; ?>

        <thead>

        </thead>
        <tbody>

        @foreach ($comunidades as $comunidad)

            @if($comunidad->cursillo != $cursillo)
                <tr>
                    <td class="cabecera4 text-center">
                        Cursillo: {!! $comunidad->cursillo !!}

                    </td>
                </tr>

                <?php $cursillo = $comunidad->cursillo; ?>
            @endif

            @if($comunidad->pais != $pais)
                <tr>
                    <td class="cabecera3 text-center">
                        País: {!! $comunidad->pais!!}

                    </td>
                </tr>

                <?php $pais = $comunidad->pais; ?>
            @endif

                <tr>
                    <td class="text-center">
                        {!! $comunidad->comunidad !!}
                    </td>
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