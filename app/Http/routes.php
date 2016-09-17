<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//Verificación de email

Route::pattern('id', '\d+'); // Los id solo pueden ser numeros

Route::get('/', ['as' => 'invitado', 'uses' => 'InvitadoController@index']);
Route::get('/', ['as' => '/', 'uses' => 'InvitadoController@index']);

Route::get('/inicio', ['as' => 'inicio', 'before' => 'csrf', 'uses' => 'AutenticadoController@index']);
Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController']);
Route::resource('usuarios', 'UsersController');
Route::get('curso/{id}', ['before' => 'csrf', 'uses' => 'CursillosController@verCursilloInicio']);
Route::get('miPerfil', array('as' => 'miPerfil', 'before' => 'csrf', 'uses' => 'UsersController@perfil'));
Route::get('register/verify/{codigoConfirmacion}', ['before' => 'csrf', 'uses' => 'InvitadoController@confirmar']);

Route::group(['middleware' => array('roles'), 'roles' => array('administrador'), 'before' => 'csrf'], function () {
    Route::resource('comunidades', 'ComunidadesController');
    Route::resource('cursillos', 'CursillosController');
    Route::resource('localidades', 'LocalidadesController');
    Route::resource('paises', 'PaisesController');
    Route::resource('provincias', 'ProvinciasController');
    Route::resource('calendarioCursos', 'CalendarioCursosController');
    Route::resource('tiposSecretariados', 'TiposSecretariadosController');
    if (config("opciones.accion.roles")) {
        Route::resource('roles', 'RolesController');
    }
    if (config("opciones.accion.tiposParticipantes")) {
        Route::resource('tiposParticipantes', 'TiposParticipantesController');
    }
    if (config("opciones.accion.tipoComunicacionesPreferidas")) {
        Route::resource('tiposComunicacionesPreferidas', 'TiposComunicacionesPreferidasController');
    }
    Route::resource('solicitudesEnviadas', 'SolicitudesEnviadasController');
    Route::resource('solicitudesRecibidas', 'SolicitudesRecibidasController');
    Route::get('nuestrasRespuestas', array('as' => 'nuestrasRespuestas', 'uses' => 'NuestrasRespuestasController@index'));
    Route::get('nuestrasSolicitudes', array('as' => 'nuestrasSolicitudes', 'uses' => 'NuestrasSolicitudesController@index'));
//Copia de seguridad
    if (config("opciones.accion.copiaSeguridad")) {
        Route::get('copiaSeguridad', array('as' => 'copiaSeguridad', 'uses' => 'CopiaSeguridadController@index'));
        Route::post('comenzarCopiaSeguridad', array('as' => 'comenzarCopiaSeguridad', 'uses' => 'CopiaSeguridadController@comenzarCopia'));
    }
//Cerrar año
    if (config("opciones.accion.cerrarAnyo")) {
        Route::get('cerrarAnyo', array('as' => 'cerrarAnyo', 'uses' => 'CerrarAnyoController@getAnyo'));
        Route::post('borrarTablas', array('as' => 'borrarTablas', 'uses' => 'CerrarAnyoController@borrarTablas'));
    }
    Route::post('comprobarNuestrasSolicitudes', array('as' => 'comprobarNuestrasSolicitudes', 'uses' => 'NuestrasSolicitudesController@comprobarSolicitudes'));
    Route::post('enviarNuestrasSolicitudes', array('as' => 'enviarNuestrasSolicitudes', 'uses' => 'NuestrasSolicitudesController@enviar'));
    Route::post('comprobarNuestrasRespuestas', array('as' => 'comprobarNuestrasRespuestas', 'uses' => 'NuestrasRespuestasController@comprobarRespuestas'));
    Route::post('enviarNuestrasRespuestas', array('as' => 'enviarNuestrasRespuestas', 'uses' => 'NuestrasRespuestasController@enviar'));


    //Cambio de Provincias y localidades vía ajax.
    Route::post('cambiarProvincias', array('as' => 'cambiarProvincias', 'uses' => 'ProvinciasController@cambiarProvincias'));
    Route::post('cambiarLocalidades', array('as' => 'cambiarLocalidades', 'uses' => 'LocalidadesController@cambiarLocalidades'));

    //Cálculo del total de años de los cursos de una comunidad vía Ajax
    Route::post('totalAnyos', array('as' => 'totalAnyos', 'uses' => 'CursillosController@totalAnyos'));

    //Cambio de las comunidades según tipo de comunicación solicitudes
    Route::post('cambiarComunidadesNoPropiasSolicitudes', array('as' => 'cambiarComunidadesNoPropiasSolicitudes', 'uses' => 'ComunidadesController@cambiarComunidadesNoPropiasSolicitudes'));

    //Cambio de las comunidades según tipo de comunicación respuestas
    Route::post('cambiarComunidadesNoPropiasRespuestas', array('as' => 'cambiarComunidadesNoPropiasRespuestas', 'uses' => 'ComunidadesController@cambiarComunidadesNoPropiasRespuestas'));

    //Cálculo del total de años de los cursos de un conjunto de comunidades vía Ajax
    Route::post('totalAnyosRespuestas', array('as' => 'totalAnyosRespuestas', 'uses' => 'CursillosController@totalAnyosRespuestas'));

    //Cálculo del total de semanas por año vía Ajax
    Route::post('semanasTotales', array('as' => 'semanasTotales', 'uses' => 'CursillosController@semanasTotales'));

    //Cálculo del total de semanas por año vía Ajax
    Route::post('fechasInicioCursosResultado', array('as' => 'fechasInicioCursosResultado', 'uses' => 'CursillosController@fechasInicioCursosResultado'));

    //Cálculo del total de semanas para nuestras respuestas u nuestras solicitudes por año vía Ajax
    Route::post('fechasInicioCursosSolicitud', array('as' => 'fechasInicioCursosSolicitud', 'uses' => 'CursillosController@fechasInicioCursosSolicitud'));

    //Obtener relación de cursos vía Ajax (ModoTabla)
    Route::post('listadoCursillosSolicitudes', array('as' => 'listadoCursillosSolicitudes', 'uses' => 'CursillosController@listadoCursillosSolicitudes'));

    //Obtener relación de cursos excepto los míos vía Ajax (ModoTabla)
    Route::post('listadoCursillosRespuestas', array('as' => 'listadoCursillosRespuestas', 'uses' => 'CursillosController@listadoCursillosRespuestas'));


    //Obtener relación de cursos vía Ajax (ModoSelect)
    Route::post('cursillosTotales', array('as' => 'ponerCursillosTotales', 'uses' => 'CursillosController@cursillosTotales'));

    //Obtener relación de semanas con solicitudes recibidas vía Ajax (ModoSelect)
    Route::post('semanasSolicitudesEnviadas', array('as' => 'semanasSolicitudesEnviadas', 'uses' => 'PdfController@semanasSolicitudesEnviadas'));

    //Obtener relación de semanas con solicitudes recibidas vía Ajax (ModoSelect)
    Route::post('semanasSolicitudesRecibidas', array('as' => 'semanasSolicitudesRecibidas', 'uses' => 'PdfController@semanasSolicitudesRecibidas'));

    //Obtener relación de semanas con solicitudes recibidas vía Ajax (ModoSelect)
    Route::post('semanasSolicitudesRecibidasCursillos', array('as' => 'semanasSolicitudesRecibidasCursillos', 'uses' => 'PdfController@semanasSolicitudesRecibidasCursillos'));
    //Listados PDF
    // Listado Cursillos en el mundo
    Route::get('cursillosPaises', 'PdfController@getCursillos');
    Route::post('imprimirCursillos', array('as' => 'imprimirCursillos', 'uses' => 'PdfController@imprimirCursillos'));

    // Listado Intendendencia para clausura
    Route::get('intendenciaClausura', 'PdfController@getComunidades');
    Route::post('imprimirComunidades', array('as' => 'imprimirComunidades', 'uses' => 'PdfController@imprimirComunidades'));

    // Listado Secretariado
    Route::get('secretariado', array('as' => 'secretariado', 'uses' => 'PdfController@getSecretariado'));
    Route::post('imprimirSecretariado', array('as' => 'imprimirSecretariado', 'uses' => 'PdfController@imprimirSecretariado'));

    // Listado Secretariados Activos por Pais
    Route::get('secretariadosPais', 'PdfController@getSecretariadosPais');
    Route::post('imprimirSecretariadosPais', array('as' => 'imprimirSecretariadosPais', 'uses' => 'PdfController@imprimirSecretariadosPais'));

    // Listado Secretariados Inactivos por Pais
    Route::get('secretariadosPaisInactivos', 'PdfController@getSecretariadosPaisInactivos');
    Route::post('imprimirSecretariadosPaisInactivos', array('as' => 'imprimirSecretariadosPaisInactivos', 'uses' => 'PdfController@imprimirSecretariadosPaisInactivos'));

    // Listado Secretariados Activos no colaboradores
    Route::get('noColaboradores', 'PdfController@getNoColaboradores');
    Route::post('imprimirNoColaboradores', array('as' => 'imprimirNoColaboradores', 'uses' => 'PdfController@imprimirNoColaboradores'));

    // Listado Secretariados Inactivos no colaboradores
    Route::get('noColaboradoresInactivos', 'PdfController@getNoColaboradoresInactivos');
    Route::post('imprimirNoColaboradoresInactivos', array('as' => 'imprimirNoColaboradoresInactivos', 'uses' => 'PdfController@imprimirNoColaboradoresInactivos'));

    //Obtener relación de cursillos de una comunidad de una solicitud enviada
    Route::post('cursillosSolicitudEnviada', array('as' => 'cursillosSolicitudEnviada', 'uses' => 'SolicitudesEnviadasController@getCursillosSolicitudEnviada'));

    //Obtener relación de cursillos de una comunidad de una solicitud recibida
    Route::post('cursillosSolicitudRecibida', array('as' => 'cursillosSolicitudRecibida', 'uses' => 'SolicitudesRecibidasController@getCursillosSolicitudRecibida'));

    // Listado Secretariados Activos por Pais
    Route::get('imprimirPaisesActivos', 'PdfController@imprimirPaisesActivos');

    // Listado Secretariados Colaboradores Sin Responder
    Route::get('secretariadosColaboradoresSinResponder', 'PdfController@getSecretariadosColaboradoresSinResponder');
    Route::post('imprimirSecretariadosColaboradoresSinResponder', array('as' => 'imprimirSecretariadosColaboradoresSinResponder', 'uses' => 'PdfController@imprimirSecretariadosColaboradoresSinResponder'));


});

