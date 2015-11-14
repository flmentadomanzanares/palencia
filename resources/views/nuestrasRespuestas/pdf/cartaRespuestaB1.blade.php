<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>palenciaDoc-B3</title>
 </head>
<body style="font-family: Calibri;font-size: 12pt">
<div style="width:100%;text-align: center">
    <strong style="text-decoration: underline;">CURSILLOS DE CRISTIANIDAD - DIÓCESIS DE CANARIAS</strong>
    <br/>
</div>
<div>
    <span>Queridos hermanos:</span>
    <br/>
    <span style="padding-left: 2em;">Les adjuntamos nuestra intendencia para los cursillos que nos han solicitado.</span>
    <br/>
    <span style="padding-left: 2em;">Por favor hagan fotocopia y rellenen los datos de cada uno de ellos, en el documento adjunto.</span>
    <br/>
    <span style="padding-left: 2em;">Les deseamos el mayor de los éxitos para la Gloria de Dios. Los cursillos por los que oraremos son los siguientes:</span>
    <br/>
    <ul>
        @foreach($cursos as $curso)
            <li style="padding-left: 2em;">{{ $curso }}</li>
        @endforeach
    </ul>
    <br/>
    <span>Les rogamos que en lo sucesivo utilicen las siguientes vías de contacto:</span>
    <br/>
    <span><strong>Por correo electrónico:</strong></span>
    <br/>
    <span style="padding-left: 2em;">Para solicitar nuestra intendencia: <a
                href="{{$remitente->email_solicitud}}">{{$remitente->email_solicitud}}</a></span>
    <br/>
    <span style="padding-left: 2em;">Para enviarnos la vuestra: <a
                href="{{$remitente->email_envio}}">{{$remitente->email_envio}}</a></span>
    <br/>
    <span><strong>Por correo postal:</strong></span>
    <br/>
    <span style="padding-left: 2em;">{{$remitente->direccion_postal}} {{$remitente->localidad}}-{{$remitente->cp}}
        -{{$remitente->pais}}</span>
    <br/>
    <br/>
    <span>Un fuerte abrazo:</span>
    <br/>
    <span style="padding-left: 2em;"><strong>{{$remitente->comunidad}}-{{$remitente->pais}}</strong></span>
    <br/>
    <div style="text-align: right" >
        ¡
        <span style="color: rgb(255, 170, 1)">D</span>
        <span style="color: rgb(101, 199, 88)">E</span>
        <span style=""> </span>
        <span style="color: color: rgb(252, 59, 0)">C</span>
        <span style="color: rgb(5, 232, 251)">O</span>
        <span style="color: rgb(226, 165, 173)">L</span>
        <span style="color: rgb(252, 241, 3)">O</span>
        <span style="lcolor:color: rgb(177, 156, 251)">R</span>
        <span style="color:rgb(0, 173, 189)">E</span>
        <span style="color:rgb(249, 17, 253)">S</span>
        !
    </div>
</div>
</body>
</html>
