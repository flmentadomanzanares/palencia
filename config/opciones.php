<?php
/**
 * Created by PhpStorm.
 * User: fmentado
 * Date: 05/05/2015
 * Time: 8:40
 */
return ['campoUser' => [
    'fullname' => 'Nombre',
    'name' => 'Usuario',
    'email' => 'Email',
    'activo' => 'Activo',
    'nactivo' => 'No Activo',
    'confirmado' => 'Confirmado',
    'nconfirmado' => 'No Confirmado',
], 'paginacion' => 400,
    'numeroComunidadesPropias' => 2,
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
        'comunidadesMax' => 0, //0=todos
    ],
    'tipo' => [
        'carta' => 'carta',
        'email' => 'email',
    ],
    "emailTestSender" => [
        "active" => true,
        "email" => 'franciscomentadomanzanares@gmail.com',
    ],

];
?>