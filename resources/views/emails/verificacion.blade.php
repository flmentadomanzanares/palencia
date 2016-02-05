<!DOCTYPE html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Verificación de la cuenta PALENCIA</h2>

<div>
    Gracias por crear una cuenta en nuestra comunidad
    Por favor, haz clic en el enlace para activar la cuenta.
    {{ URL::to('register/verify/' .  $codigoConfirmacion) }}.<br/>
</div>
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
</body>
</html>
