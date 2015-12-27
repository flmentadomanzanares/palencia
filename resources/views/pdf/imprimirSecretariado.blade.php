<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Secretariados por país</title>

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

        .cabecera4 {

            background-color: #FF7A00;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 16px;

        }

        .cabecera5 {

            color: #000000;
            /*background-color: #400090;
            color: #FFFFFF;*/
            font-weight: bold;
            font-size: 20px;
            padding-top:20px;
            padding-bottom:20px;
            border: 1px solid #4a4949;

        }

        table thead, table th {
            /*background-color: #9d9d9d;*/
            border: 1px solid #4a4949;
            font-size: 18px;
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

    </style>
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
                <th>Cursillo</th>
                <th>Fecha Inicio</th>

            </tr>
        </thead>
        <tbody>

        @foreach ($solicitudesEnviadas as $solicitudEnviada)

            <tr>
               <td>
                   {!! $solicitudEnviada->cursillo !!}
                </td>
                <td class="text-center">
                    {!! Date("d/m/Y" , strtotime($solicitudEnviada->fecha_inicio) ) !!}
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
            <th>Cursillo</th>
            <th>Fecha Inicio</th>

        </tr>
        </thead>
        <tbody>

        @foreach ($solicitudesRecibidas as $solicitudRecibida)

            <tr>
                <td>
                    {!! $solicitudRecibida->cursillo !!}
                </td>
                <td class="text-center">
                    {!! Date("d/m/Y" , strtotime($solicitudRecibida->fecha_inicio) ) !!}
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