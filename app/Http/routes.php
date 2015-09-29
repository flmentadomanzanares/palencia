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

Route::get('inicio', 'AutenticadoController@index');

Route::controllers([

    'auth'      => 'Auth\AuthController',
    'password'  => 'Auth\PasswordController'

]);


//Rutas Controladores RestFull
Route::resource('calendario','CalendarioController');
Route::resource('comunidades','ComunidadesController');
Route::resource('cursillos','CursillosController');
Route::resource('localidades','LocalidadesController');
Route::resource('paises','PaisesController');
Route::resource('provincias','ProvinciasController');
Route::resource('roles','RolesController');
Route::resource('calendarioCursos','CalendarioCursosController');
Route::resource('solicitudesEnviadas','SolicitudesEnviadasController');
Route::resource('solicitidesRecibidas','SolicitudesRecibidasController');
Route::resource('usuarios','UsersController');



Route::get('aboutus', 'ComunController@mostrarAboutUs');
Route::get('contacto', 'ComunController@mostrarContacto');
Route::post('enviar', 'ComunController@enviarCorreo');


//Ruta para cambio de Provincias y localidades vía ajax.
Route::post('cambiarProvincias', array('as'=>'cambiarProvincias','before'=>'csrf','uses'=>'ProvinciasController@cambiarProvincias'));
Route::post('cambiarLocalidades', array('as'=>'cambiarLocalidades','before'=>'csrf','uses'=>'LocalidadesController@cambiarLocalidades'));
