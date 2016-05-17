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
],
    'roles' => [
        'administrador' => '400',
    ],
    'seguridad' => [
        'Email' => true,
        'recordarPassword' => true,
        'captcha' => false,
    ],
    'accion' => [
        'copiaSeguridad' => true,
        'cerrarAnyo' => true,
        'crearSusRespuestasConSolicitudesAnterioresRealizadas' => false,
        'roles' => false,
        'tiposParticipantes' => false,
        'tipoComunicacionesPreferidas' => false,
        'mostrarModalDeBorrado' => true,
        'cartaCumplimentadaIndividualNuestrasRespuestas' => false,

    ],
    'envios' => [
        'timeout' => 30,
        'seMaxtTimeAt' => 30,
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