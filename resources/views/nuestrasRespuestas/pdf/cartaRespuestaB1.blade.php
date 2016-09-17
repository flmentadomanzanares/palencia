<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>palenciaDoc-B1</title>
</head>
<body style="font-family: Calibri;font-size: 12pt">
<div style="width:100%;text-align: center">
    <strong style="font-size:18px;text-decoration: underline;line-height:1.6;">{{$remitente->comunidad}}</strong>
    <br/>
</div>
<div>
    <span style="font-size:16px;line-height:1.6;padding-left: 2em;text-align: justify">Queridos hermanos: Les adjuntamos nuestra intendencia para los cursillos que nos han solicitado.</span>
    <br/>
    <span style="font-size:16px;line-height:1.6;text-align: justify">Por favor hagan fotocopia y rellenen los datos de cada uno de ellos, en el documento adjunto.</span>
    <br/>
    <span style="font-size:16px;line-height:1.6;text-align: justify">Les deseamos el mayor de los &eacute;xitos para la Gloria de Dios. Los cursillos por los que oraremos son los siguientes:</span>
    <br/>
    <ul>
        @foreach($cursos as $curso)
            <li style="font-size:16px;padding-left: 1.5em;line-height:1.6;">{{ $curso }}</li>
        @endforeach
    </ul>
    <br/>
    <span style="font-size:16px;line-height:1.6;text-align: justify">Les rogamos que en lo sucesivo utilicen las siguientes v&iacute;as de contacto:</span>
    <br/>
    <span><strong style="font-size:16px;line-height:1.6;text-align: justify">Por correo
            electr&oacute;nico:</strong></span>
    <br/>
    {{--<span style="padding-left: 2em;font-size:16px;line-height:1.6;text-align: justify">Para solicitar nuestra intendencia: <a
                href="{{$remitente->email_solicitud}}">{{$remitente->email_solicitud}}</a></span>
    <br/>--}}
    <span style="padding-left: 2em;font-size:16px;line-height:1.6;text-align: justify">Para enviarnos la vuestra: <a
                href="{{$remitente->email_envio}}">{{$remitente->email_envio}}</a></span>
    <br/>
    {{-- <span><strong style="font-size:16px;line-height:1.6;text-align: justify">Por correo postal:</strong></span>
     <br/>
     <span style="padding-left: 2em; font-size:16px;line-height:1.6;text-align: justify">{{$remitente->direccion_postal}} {{$remitente->localidad}}
         -{{$remitente->cp}}
         -{{$remitente->pais}}</span>
     <br/>--}}
    <br/>
    <span style="font-size:16px;line-height:1.6;text-align: justify">Un fuerte abrazo:</span>
    <br/>
    <span style="padding-left: 2em;"><strong
                style="font-size:16px;line-height:1.6;text-align: justify">{{$remitente->comunidad}}
            -{{$remitente->pais}}</strong></span>
    <br/>

    <div style="text-align: right;font-size:20px;line-height:1.6">
        <strong>¡
            <span style="color: rgb(220, 100, 1)">D</span>
            <span style="color: rgb(50, 180, 1)">E</span>
            <span style=""> </span>
            <span style="color:rgb(252, 59, 0)">C</span>
            <span style="color: rgb(5, 100, 255)">O</span>
            <span style="color: rgb(130, 100, 50)">L</span>
            <span style="color: rgb(220, 150, 1)">O</span>
            <span style="color: rgb(177, 100, 251)">R</span>
            <span style="color:rgb(0, 100, 189)">E</span>
            <span style="color:rgb(249, 17, 200)">S</span>
            !</strong>
    </div>
</div>
</body>
</html>
