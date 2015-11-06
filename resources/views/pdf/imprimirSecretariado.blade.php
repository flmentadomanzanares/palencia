<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Secretariados por país</title>
    {!! HTML::style('css/pdf.css') !!}
</head>
<body>
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class=" cabecera1 text-center">
    {{ $titulo }} {!! $secretariado->comunidad !!}<br/>
</div>

<div class=" cabecera2">
    Fecha: {{ $date }}
</div>

@if(!$solicitudesRecibidas->isEmpty() || !$solicitudesEnviadas->isEmpty() )

    <div class="cabecera5 text-center">Solicitudes Enviadas</div><br/>

    <table border="0" cellspacing="0" cellpadding="0">

        <thead>
            <tr>
                <th>Comunidad</th>
                <th>Cursillo</th>

            </tr>
        </thead>
        <tbody>

        @foreach ($solicitudesEnviadas as $solicitudEnviada)

            <tr>
                <td>
                    {!! $solicitudEnviada->comunidad !!}
                </td>
                <td>
                    {!! $solicitudEnviada->cursillo !!}
                </td>
            </tr>
        @endforeach

        </tbody>
        <br/>
    </table>

    <div class="cabecera5 text-center">Solicitudes Recibidas</div><br/>

    <table border="0" cellspacing="0" cellpadding="0">

        <thead>
        <tr>
            <th>Comunidad</th>
            <th>Cursillo</th>

        </tr>
        </thead>
        <tbody>

        @foreach ($solicitudesRecibidas as $solicitudRecibida)

            <tr>
                <td>
                    {!! $solicitudRecibida->comunidad !!}
                </td>
                <td>
                    {!! $solicitudRecibida->cursillo !!}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
@else
    <div>
        <div class="cabecera4 text-center">
            <p>¡Aviso! - No se ha encontrado ninguna solicitud que listar para el secretariado solicitado.</p>
        </div>
    </div>
@endif
</body>
</html>