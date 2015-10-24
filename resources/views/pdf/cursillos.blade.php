<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cursillos en el Mundo</title>
    {!! HTML::style('css/pdf.css') !!}
</head>
<body>

<h1>{{ $titulo }}</h1>
{{ $semana }}<br/>
{{ $date }}
<table border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
        <th class="no">PAIS</th>
        <th class="desc">CURSILLO</th>
        <th class="unit">FECHA DE INICIO</th>
        <th class="total">FECHA FINAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($cursillos as $cursillo)

        <tr>
            <td class="no">{{ $cursillo->pais_id }}</td>
        <td class="no">{{ $cursillo->cursillo }}</td>
        <td class="desc">{{ $cursillo->fecha_inicio }}</td>
        <td class="unit">{{ $cursillo->fecha_final }}</td>
    </tr>
    @endforeach


    </tbody>

</table>

</body>
</html>