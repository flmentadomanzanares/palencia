<?php
/**
 * Created by PhpStorm.
 * User: fmentado
 * Date: 05/05/2015
 * Time: 8:40
 */
return [
    'verErrorMailServer' => true,
    'paginacion' => 250,
    'numeroComunidadesPropias' => 1,
    'incluirModalAltas' => false,
    'campoUser' => [
        'fullname' => 'Nombre',
        'name' => 'Usuario',
        'email' => 'Email',
        'activo' => 'Activo',
        'nactivo' => 'No Activo',
        'confirmado' => 'Confirmado',
        'nconfirmado' => 'No Confirmado',
    ],
    'roles' => [
        'administrador' => '400',
    ],
    'seguridad' => [
        'Email' => false,
        'recordarPassword' => false,
        'captcha' => false,
    ],
    'accion' => [
        'copiaSeguridad' => true,
        'cerrarAnyo' => true,
        'roles' => false,
        'tiposParticipantes' => false,
        'tipoComunicacionesPreferidas' => false,
        'mostrarModalDeBorrado' => true,
        'cartaCumplimentadaIndividualNuestrasRespuestas' => false,
    ],
    'listados' => [
        'mostrarListados' => true,
        'cursillosPaises' => true,
        'intendenciaClausura' => true,
        'secretariado' => true,
        'secretariadosPais' => true,
        'secretariadosPaisInactivos' => true,
        'noColaboradores' => true,
        'noColaboradoresInactivos' => true,
        'imprimirPaisesActivos' => true,
        'secretariadosColaboradoresSinResponder' => true,
    ],
    'envios' => [
        'timeout' => 0,
        'seMaxtTimeAt' => 0,
    ],
    'maxComunidadesEnvioSolicitudes' => [
        'maxComunidades' => 0 //Todos
    ],
    'maxComunidadesEnviorespuestas' => [
        'maxComunidades' => 0 //Todos
    ],
    'tipo' => [
        'carta' => 'carta',
        'email' => 'email',
    ],
    "emailTestSender" => [
        "active" => true,
        "email" => 'fmentado@koalnet.es',
    ],
    "copiaDeSeguridad" => [
        "comprimido" => [
            "extensionArchivo" => "sql",
        ],
        "sinComprimir" => [
            "extensionArchivo" => "txt",
        ],
        "directorioBase" => "backups",
        "usarCompresion" => true,
    ]
];
?>