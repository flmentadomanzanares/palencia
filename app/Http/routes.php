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

Route::get('inicio',['as'=>'inicio','uses'=>'AutenticadoController@index']);

Route::controllers(['auth'=> 'Auth\AuthController','password'=> 'Auth\PasswordController']);

//Rutas Controladores RestFull
Route::resource('comunidades','ComunidadesController');
Route::resource('cursillos','CursillosController');
Route::resource('localidades','LocalidadesController');
Route::resource('paises','PaisesController');
Route::resource('provincias','ProvinciasController');
Route::resource('roles','RolesController');
Route::resource('calendarioCursos','CalendarioCursosController');
Route::resource('usuarios','UsersController');
//Route::resource('tiposParticipantes','TiposParticipantesController');
Route::resource('tiposSecretariados','TiposSecretariadosController');
/*Route::resource('solicitudesEnviadas','SolicitudesEnviadasController');
Route::resource('solicitudesRecibidas','SolicitudesRecibidasController');*/
Route::resource('nuestrasRespuestas','NuestrasRespuestasController');
Route::resource('nuestrasSolicitudes','NuestrasSolicitudesController');
//Route::resource('tiposComunicacionesPreferidas','TiposComunicacionesPreferidasController');
Route::post('enviarNuestrasRespuestas', array('as'=>'enviarNuestrasRespuestas','before'=>'csrf','uses'=>'NuestrasRespuestasController@enviar'));
Route::post('enviarNuestrasSolicitudes', array('as'=>'enviarNuestrasSolicitudes','before'=>'csrf','uses'=>'NuestrasSolicitudesController@enviar'));

//Cambio de Provincias y localidades vía ajax.
Route::post('cambiarProvincias', array('as'=>'cambiarProvincias','before'=>'csrf','uses'=>'ProvinciasController@cambiarProvincias'));
Route::post('cambiarLocalidades', array('as'=>'cambiarLocalidades','before'=>'csrf','uses'=>'LocalidadesController@cambiarLocalidades'));

//Cálculo del total de semanas por año vía Ajax
Route::post('semanasTotales', array('as'=>'semanasTotales','before'=>'csrf','uses'=>'CursillosController@semanasTotales'));

//Obtener relación de cursos vía Ajax
Route::post('listadoCursillos', array('as'=>'listadoCursillos','before'=>'csrf','uses'=>'CursillosController@listadoCursillos'));

//Listados PDF

// Listado Cursillos en el mundo
Route::get('cursillosPaises', 'PdfController@getCursillos');
Route::post('imprimirCursillos', array('as'=>'imprimirCursillos','before'=>'csrf','uses'=>'PdfController@imprimirCursillos'));

// Listado Intendendencia para clausura
Route::get('intendenciaClausura', 'PdfController@getComunidades');
Route::post('imprimirComunidades', array('as'=>'imprimirComunidades','before'=>'csrf','uses'=>'PdfController@imprimirComunidades'));

// Listado Secretariado
Route::get('secretariado', 'PdfController@getSecretariado');
Route::post('imprimirSecretariado', array('as'=>'imprimirSecretariado','before'=>'csrf','uses'=>'PdfController@imprimirSecretariado'));

// Listado Secretariados por Pais
Route::get('secretariadosPais', 'PdfController@getSecretariadosPais');
Route::post('imprimirSecretariadosPais', array('as'=>'imprimirSecretariadosPais','before'=>'csrf','uses'=>'PdfController@imprimirSecretariadosPais'));