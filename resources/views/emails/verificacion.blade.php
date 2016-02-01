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
    {{ URL::to('register/verify/' . $codigoConfirmacion) }}.<br/>

</div>

</body>
</html>
