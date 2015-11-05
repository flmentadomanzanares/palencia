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

        </thead>
        <tbody>
        <br />

        @foreach ($solicitudesEnviadas as $solicitudEnviada)

            <tr>
                <th >
                    {!! $solicitudEnviada->comunidad !!}
                </th>
                <th >
                    {!! $solicitudEnviada->cursillo !!}
                </th>
            </tr>
        @endforeach

        </tbody>
</table>

    <div class="cabecera5 text-center">Solicitudes Recibidas</div><br/>

    <table border="0" cellspacing="0" cellpadding="0">

        <thead>

        </thead>
        <tbody>

        @foreach ($solicitudesRecibidas as $solicitudRecibida)

            <tr>
                <th >
                    {!! $solicitudRecibida->comunidad !!}
                </th>
                <th >
                    {!! $solicitudRecibida->cursillo !!}
                </th>
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