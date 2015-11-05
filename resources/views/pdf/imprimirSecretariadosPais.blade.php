<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Secretariados por país</title>
    {!! HTML::style('css/pdf.css') !!}
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class=" cabecera1 text-center">
    {{ $titulo }} {!! $pais->pais !!}<br/>
</div>

<div class=" cabecera2">
    Fecha: {{ $date }}
</div>

@if(!$comunidades->isEmpty())

    <div class="cabecera5 text-center">Secretariados</div><br/>

<table border="0" cellspacing="0" cellpadding="0">

        <thead>

        </thead>
        <tbody>

        @foreach ($comunidades as $comunidad)

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
        <div class="cabecera2 text-center">
            <p>¡Aviso! - No se ha encontrado ningun secretariado que listar para el país solicitado.</p>
        </div>
    </div>
@endif
</body>
</html>