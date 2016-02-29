<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::post('damedepartamentos', array('uses' => 'HomeController@dameDepartamentos'));

Route::post('dameprovincias/{iddep}', array('uses' => 'HomeController@dameProvincias'));

Route::post('damedistritos/{idpro}', array('uses' => 'HomeController@dameDistritos'));

Route::post('damecanchas/{idloc}', array('uses' => 'HomeController@dameCanchas'));

Route::get('search-cancha', function(){
	return View::make('search');
});

Route::post('datosconfirmar', array('uses' => 'AlquilerController@datosConfirmar'));

Route::post('reserva', array('uses' => 'AlquilerController@realizarAlquiler'));

Route::get('vercalendario/{idloc}', array('uses' => 'CanchaController@calendarioLocal'));

Route::post('calendario/{idcan}', array('uses' => 'CanchaController@verCalendario'));

Route::post('canchaslugar', array('uses' => 'CanchaController@verCanchaLugar'));

Route::post('canchanombre', array('uses' => 'CanchaController@verCanchaNombre'));

Route::group(array('before' => 'auth'), function(){

	Route::get('logout', array('uses' => 'UsuarioController@logout'));

	Route::group(array('before' => 'master'), function(){

		Route::get('lasempresas', array('uses' => 'EmpresaController@mostrarEmpresas'));

		Route::post('lasempresas', 'EmpresaController@registrarEmpresa');

		Route::get('loslocales', array('uses' => 'LocalController@mostrarLocales'));

		Route::post('loslocales', 'LocalController@registrarLocal');

		Route::get('losusuarios', array('uses' => 'UsuarioController@mostrarUsuarios'));

		Route::post('losusuarios', 'UsuarioController@registrarUsuario');
		
	});

	Route::group(array('before' => 'empresa'), function(){

		Route::get('miscanchas', array('uses' => 'CanchaController@mostrarCanchas'));

		Route::post('miscanchas', array('uses' => 'CanchaController@registrarCancha'));

		Route::get('misperiodos', array('uses' => 'PeriodoController@mostrarPeriodos'));

		Route::post('misperiodos', array('uses' => 'PeriodoController@registrarPeriodo'));

	});

});

Route::group(array('before' => 'guest'), function(){

	Route::get('registro', array('uses' => 'UsuarioController@mostrarRegistro'));

	Route::post('registro', array('uses' => 'UsuarioController@registroWeb'));

	Route::get('login', array('uses' => 'UsuarioController@mostrarLogin'));

	Route::post('login', array('uses' => 'UsuarioController@login'));

    Route::get('login/fb', array('uses' => 'UsuarioController@loginFacebook'));

    Route::get('login/fb/callback', array('uses' => 'UsuarioController@loginFacebookCallback'));

});