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

Route::pattern('id', '\d+'); // Los id solo pueden ser numeros
Route::get('/', 'InvitadoController@index');
Route::get('/inicio', ['as' => 'inicio', 'uses' => 'AutenticadoController@index']);
Route::get('/enviar1', array('as' => 'enviar1', 'uses' => 'NuestrasSolicitudesController@enviar1'));
Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController']);
Route::resource('usuarios', 'UsersController');
Route::get('miPerfil', array('as' => 'miPerfil', 'before' => 'csrf', 'uses' => 'UsersController@perfil'));

Route::group(['middleware' => array('roles'), 'roles' => array('administrador'), 'before' => 'csrf'], function () {
    Route::resource('comunidades', 'ComunidadesController');
    Route::resource('cursillos', 'CursillosController');
    Route::resource('localidades', 'LocalidadesController');
    Route::resource('paises', 'PaisesController');
    Route::resource('provincias', 'ProvinciasController');
//Route::resource('roles','RolesController');
    Route::resource('calendarioCursos', 'CalendarioCursosController');


    Route::resource('tiposSecretariados', 'TiposSecretariadosController');
//Route::resource('tiposParticipantes','TiposParticipantesController');
//Route::resource('tiposComunicacionesPreferidas','TiposComunicacionesPreferidasController');

    Route::resource('solicitudesEnviadas', 'SolicitudesEnviadasController');
    Route::resource('solicitudesRecibidas', 'SolicitudesRecibidasController');
    Route::get('nuestrasRespuestas', array('as' => 'nuestrasRespuestas', 'uses' => 'NuestrasRespuestasController@index'));
    Route::get('nuestrasSolicitudes', array('as' => 'nuestrasSolicitudes', 'uses' => 'NuestrasSolicitudesController@index'));

//Copia de seguridad
    Route::get('copiaSeguridad', array('as' => 'copiaSeguridad', 'uses' => 'CopiaSeguridadController@index'));
    Route::post('comenzarCopiaSeguridad', array('as' => 'comenzarCopiaSeguridad', 'uses' => 'CopiaSeguridadController@comenzarCopia'));

    Route::post('enviarNuestrasSolicitudes', array('as' => 'enviarNuestrasSolicitudes', 'uses' => 'NuestrasSolicitudesController@enviar'));
    Route::post('enviarNuestrasRespuestas', array('as' => 'enviarNuestrasRespuestas', 'uses' => 'NuestrasRespuestasController@enviar'));


//Cambio de Provincias y localidades vía ajax.
    Route::post('cambiarProvincias', array('as' => 'cambiarProvincias', 'uses' => 'ProvinciasController@cambiarProvincias'));
    Route::post('cambiarLocalidades', array('as' => 'cambiarLocalidades', 'uses' => 'LocalidadesController@cambiarLocalidades'));

//Cálculo del total de años de los cursos de una comunidad vía Ajax
    Route::post('totalAnyos', array('as' => 'totalAnyos', 'uses' => 'CursillosController@totalAnyos'));
//Cálculo del total de semanas por año vía Ajax
    Route::post('semanasTotales', array('as' => 'semanasTotales', 'uses' => 'CursillosController@semanasTotales'));

//Obtener relación de cursos vía Ajax (ModoTabla)
    Route::post('listadoCursillos', array('as' => 'listadoCursillos', 'uses' => 'CursillosController@listadoCursillos'));

//Obtener relación de cursos vía Ajax (ModoSelect)
    Route::post('cursillosTotales', array('as' => 'ponerCursillosTotales', 'uses' => 'CursillosController@cursillosTotales'));

//Obtener relación de semanas con solicitudes recibidas vía Ajax (ModoSelect)
    Route::post('semanasSolicitudesEnviadas', array('as' => 'semanasSolicitudesEnviadas', 'uses' => 'PdfController@semanasSolicitudesEnviadas'));

//Obtener relación de semanas con solicitudes recibidas vía Ajax (ModoSelect)
    Route::post('semanasSolicitudesRecibidas', array('as' => 'semanasSolicitudesRecibidas', 'uses' => 'PdfController@semanasSolicitudesRecibidas'));
//Listados PDF
// Listado Cursillos en el mundo
    Route::get('cursillosPaises', 'PdfController@getCursillos');
    Route::post('imprimirCursillos', array('as' => 'imprimirCursillos', 'uses' => 'PdfController@imprimirCursillos'));

// Listado Intendendencia para clausura
    Route::get('intendenciaClausura', 'PdfController@getComunidades');
    Route::post('imprimirComunidades', array('as' => 'imprimirComunidades', 'uses' => 'PdfController@imprimirComunidades'));

// Listado Secretariado
    Route::get('secretariado', 'PdfController@getSecretariado');
    Route::post('imprimirSecretariado', array('as' => 'imprimirSecretariado', 'uses' => 'PdfController@imprimirSecretariado'));

// Listado Secretariados por Pais
    Route::get('secretariadosPais', 'PdfController@getSecretariadosPais');
    Route::post('imprimirSecretariadosPais', array('as' => 'imprimirSecretariadosPais', 'uses' => 'PdfController@imprimirSecretariadosPais'));

// Listado Secretariados no colaboradores
    Route::get('noColaboradores', 'PdfController@getNoColaboradores');
    Route::post('imprimirNoColaboradores', array('as' => 'imprimirNoColaboradores', 'uses' => 'PdfController@imprimirNoColaboradores'));
});

