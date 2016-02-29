<?php

class AlquilerController extends BaseController{

	public function datosConfirmar(){
		$data = Input::all();
		
		$nombrecompleto = Auth::user()->nombrecompleto;
		$email = Auth::user()->email;
		$dni = Auth::user()->dni;

		$idcancha = $data['txtIdCancha'];

		$local = Cancha::join('locales', 'canchas.idlocal', '=', 'locales.idlocal')
						->where('canchas.idcancha', '=', $idcancha)
						->select('locales.nombre', 'canchas.descripcion', 'locales.direccion')->first();

		$fecha = $data['txtFecha'];
		$hora = $data['txtHora'];
		$precio = $data['txtPrecio'];

		return View::make('cliente/confirmar-reserva', array('cancha' => $idcancha, 'nombrecompleto' => $nombrecompleto, 'email' => $email, 'dni' => $dni, 'local' => $local, 'fecha' => $fecha, 'hora' => $hora, 'precio' => $precio));
	}

	public function realizarAlquiler(){
		$data = Input::all();

		$alquiler = new Alquiler();

		$horaIngreso = substr($data['txtHora'], 0, 5);
		$horaSalida = substr($data['txtHora'], 8, 13);
		$dia = substr($data['txtFecha'], 0, 2);
		$mes = substr($data['txtFecha'], 3, 2);
		$anio = substr($data['txtFecha'], 6, 4);
		$nuevaFecha = $anio.'-'.$mes.'-'.$dia;

		$dataAlquiler = array('idusuario' => Auth::user()->idusuario, 'idcancha' => $data['txtCancha'], 'estadoalquiler' => 'No Pagado', 
							'fecha' => $nuevaFecha, 'horaingreso' => $horaIngreso, 'horasalida' => $horaSalida, 
							'estadohora' => 'Reservado', 'monto' => $data['txtPrecio']);

		$respuesta = $alquiler->registrar($data, $dataAlquiler);

		if($respuesta['error'] == true){
			return Redirect::to('/')->withErrors($respuesta['mensaje'])->withInput();
		}
		else{
			return Redirect::to('/')->with('mensaje', $respuesta['mensaje']);
		}
	}

}