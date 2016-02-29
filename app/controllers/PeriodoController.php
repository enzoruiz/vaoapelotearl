<?php

class PeriodoController extends BaseController{

	public function convertirHora($hora){
		switch ($hora) {
			case 1: $hora = "07:00"; break;
			case 2: $hora = "08:00"; break;
			case 3: $hora = "09:00"; break;
			case 4: $hora = "10:00"; break;
			case 5: $hora = "11:00"; break;
			case 6: $hora = "12:00"; break;
			case 7: $hora = "13:00"; break;
			case 8: $hora = "14:00"; break;
			case 9: $hora = "15:00"; break;
			case 10: $hora = "16:00"; break;
			case 11: $hora = "17:00"; break;
			case 12: $hora = "18:00"; break;
			case 13: $hora = "19:00"; break;
			case 14: $hora = "20:00"; break;
			case 15: $hora = "21:00"; break;
			case 16: $hora = "22:00"; break;
			case 17: $hora = "23:00"; break;
		}
		return $hora;
	}

	public function mostrarPeriodos(){
		$idempresa = Auth::user()->idempresa;
		$locales = Local::select('idlocal', 'nombre')
						->where('idempresa', '=', $idempresa)->get();

		return View::make('administrador/misperiodos', array('locales' => $locales));
	}

	public function registrarPeriodo(){
		$data = Input::all();

		$dias = array();
		if (isset($data['chkLunes'])) {
			array_push($dias, "Lunes");
		}
		if (isset($data['chkMartes'])) {
			array_push($dias, "Martes");
		}
		if (isset($data['chkMiercoles'])) {
			array_push($dias, "Miercoles");
		}
		if (isset($data['chkJueves'])) {
			array_push($dias, "Jueves");
		}
		if (isset($data['chkViernes'])) {
			array_push($dias, "Viernes");
		}
		if (isset($data['chkSabado'])) {
			array_push($dias, "Sabado");
		}
		if (isset($data['chkDomingo'])) {
			array_push($dias, "Domingo");
		}

		$data['cboHoraInicio'] = $this->convertirHora($data['cboHoraInicio']);
		$data['cboHoraFin'] = $this->convertirHora($data['cboHoraFin']);

		$can = count($dias);
		$secruza = false;
		for ($i=0; $i < $can; $i++) {
			$miDia = $dias[$i];
			$res = Periodo::validarCrucePeriodo($miDia, $data['cboCancha'], 
								$data['cboHoraInicio'], $data['cboHoraFin']);
			if ($res == false) {
				$secruza = true;
			}
		}

		if ($secruza == false) {
			$respuesta = Periodo::registrar($data, $dias);
			if($respuesta['error'] == true){
				return Redirect::to('misperiodos')->withErrors($respuesta['mensaje'])->withInput();
			}
			else{
				return Redirect::to('misperiodos')->with('mensaje', $respuesta['mensaje']);
			}
		}
		else{
			$respuesta['mensaje'] = "El periodo ingresado se cruza con otro ya registrado, porfavor ingrese un periodo valido.";
			return Redirect::to('misperiodos')->withErrors($respuesta['mensaje'])->withInput();
		}


	}

}