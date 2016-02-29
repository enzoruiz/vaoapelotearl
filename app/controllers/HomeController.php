<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function dameDepartamentos(){
		$departamentos = DB::select('SELECT iddepartamento, nombre FROM departamentos');
		echo json_encode($departamentos);
	}

	public function dameProvincias($iddep){
		$provincias = DB::select('SELECT idprovincia, nombre FROM provincias WHERE iddepartamento = ?', array($iddep));
		echo json_encode($provincias);
	}

	public function dameDistritos($idpro){
		$distritos = DB::select('SELECT iddistrito, nombre FROM distritos WHERE idprovincia = ?', array($idpro));
		echo json_encode($distritos);
	}

	public function dameCanchas($idloc){
		$canchas = DB::select('SELECT idcancha, descripcion FROM canchas WHERE idlocal = ?', array($idloc));
		echo json_encode($canchas);
	}

}