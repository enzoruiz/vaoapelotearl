<?php

class CanchaController extends BaseController{

	public function dameNombreDia($fecha){
		date_default_timezone_set('America/Lima');
		$numdia = date('w', strtotime($fecha));
		switch ($numdia) {
			case 0:
				$nombredia = "Domingo";
				break;
			case 1:
				$nombredia = "Lunes";
				break;
			case 2:
				$nombredia = "Martes";
				break;
			case 3:
				$nombredia = "Miercoles";
				break;
			case 4:
				$nombredia = "Jueves";
				break;
			case 5:
				$nombredia = "Viernes";
				break;
			case 6:
				$nombredia = "Sabado";
				break;
			default:
				$nombredia = "-";
				break;
		}
		return $nombredia;
	}

	public function sumarDiasFecha($fecha, $dias){
		$nuevafecha = strtotime ( '+' . $dias . ' day' , strtotime ( $fecha ) ) ;
		$nuevafecha = date ( 'd-m-Y' , $nuevafecha );
		return $nuevafecha;
	}

	public function getIndex(){
		return View::make('cliente/canchas');
	}

	public function verCanchaNombre(){
		$data = Input::all();
		$nombre = $data['txtBusquedaCancha'];
		$fecha = $data['dpcalendario'];
		$hora = $data['cboHoraCancha'];

		$nombre = strtoupper(strstr($nombre, '  ', true));
		$dia = substr($fecha, 0, 2);
		$mes = substr($fecha, 3, 2);
		$anio = substr($fecha, 6, 4);
		$nuevaFecha = $anio.'-'.$mes.'-'.$dia;
		$horaIngreso = substr($hora, 0, 5);
		$cantidad = Cancha::localAtencion($nuevaFecha, $horaIngreso, $nombre);
		$respuesta = array();

		if($cantidad[0]->cantidad > 0){
			$canchasLibres = Cancha::canchasLibres($nombre, $nuevaFecha, $horaIngreso);
			if (count($canchasLibres > 0) && $canchasLibres != null) {
				$local = Local::join('distritos', 'locales.iddistrito', '=', 'distritos.iddistrito')
						->join('provincias', 'distritos.idprovincia', '=', 'provincias.idprovincia')
						->where('locales.nombre', '=', $nombre)
						->select('locales.idlocal', 'locales.idempresa', 'locales.nombre', 'provincias.nombre as provincia', 'distritos.nombre as distrito', 'locales.direccion', 'locales.telefono', 'locales.calificacion', 'locales.servicios', 'locales.fotoprincipal', 'locales.foto2', 'locales.foto3')->first();
				return View::make('cliente/canchanombre', array('local' => $local, 'canchas' => $canchasLibres, 'hora' => $hora, 'fecha' => $fecha));
			}
			else{
				$respuesta['mensaje'] = "Lo sentimos pero " . $nombre . " no tiene canchas disponibles en la hora " . $hora . ".";
				return Redirect::to('/')->withErrors($respuesta['mensaje'])->withInput();
			}
		}
		else{
			$respuesta['mensaje'] = "Lo sentimos pero no hay horario disponible para la cancha ingresada.";
			return Redirect::to('/')->withErrors($respuesta['mensaje'])->withInput();
		}
	}

	public function verCanchaLugar(){
		$data = Input::all();
		$iddistrito = $data['cboDistritos'];
		$fecha = $data['dpcalendario2'];
		$hora = $data['cboHoraCancha'];

		$horaIngreso = substr($hora, 0, 5);
		$dia = substr($fecha, 0, 2);
		$mes = substr($fecha, 3, 2);
		$anio = substr($fecha, 6, 4);
		$nuevaFecha = $anio.'-'.$mes.'-'.$dia;

		$cantidad = Cancha::localAtencionDistrito($nuevaFecha, $horaIngreso, $iddistrito);
		$respuesta = array();

		if(count($cantidad) > 0){
			$listaCanchas = array();
			$cant = count($cantidad);
			for ($i=0; $i < $cant; $i++) { 
				$canlib = Cancha::canchasLibres($cantidad[$i]->nombre, $nuevaFecha, $horaIngreso);
				if(count($canlib) > 0){
					$local = Local::join('distritos', 'locales.iddistrito', '=', 'distritos.iddistrito')
							->join('provincias', 'distritos.idprovincia', '=', 'provincias.idprovincia')
							->where('locales.nombre', '=', $cantidad[$i]->nombre)
							->select('locales.idlocal', 'locales.idempresa', 'locales.nombre', 'provincias.nombre as provincia', 'distritos.nombre as distrito', 'locales.direccion', 'locales.telefono', 'locales.calificacion')->first();
					$listaCanchas[$i] = array('local' => $local, 'canchas' => $canlib);
				}
			}

			if(count($listaCanchas) > 0){
				return View::make('cliente/canchaslugar', array('listacanchas' => $listaCanchas, 'hora' => $hora, 'fecha' => $fecha));
			}
			else{
				$respuesta['mensaje'] = "Lo sentimos pero no hay Locales en ese Distrito con Canchas disponibles en la hora " . $hora . ".";
				return Redirect::to('/')->withErrors($respuesta['mensaje'])->withInput();
			}
		}
		else{
			$respuesta['mensaje'] = "Lo sentimos pero no hay Locales en ese Distrito que atiendan en la hora " . $hora . ".";
			return Redirect::to('/')->withErrors($respuesta['mensaje'])->withInput();
		}
	}

	public function calendarioLocal($idloc){
		$local = Local::join('distritos', 'locales.iddistrito', '=', 'distritos.iddistrito')
						->join('provincias', 'distritos.idprovincia', '=', 'provincias.idprovincia')
						->where('locales.idlocal', '=', $idloc)
						->select('locales.idlocal', 'locales.nombre', 'provincias.nombre as provincia', 'distritos.nombre as distrito', 'locales.direccion', 'locales.telefono', 'locales.calificacion')->first();
		$canchas = Cancha::where('idlocal', '=', $idloc)
					->select('idcancha', 'descripcion')->get();

		return View::make('cliente/calendario', array('local' => $local, 'canchas' => $canchas));
	}

	public function verCalendario($idcan){
		// Primero construyo la tabla, por filas en un for y luego por columnas en otro for
		// La columna 0 es de las Horas
		// La fila 0 es de los Dias
		// Coloco el boton en el horario que atiende el local en esa cancha
		// Verifico si tiene reserva o alquiler
		date_default_timezone_set('America/Lima');
		$fechaHoy = date('d-m-Y');
		$tabla = '';
		$tabla = $tabla . '<table class="table table-condensed">';

		$atencion = Dia::join('periodos', 'dias.iddia', '=', 'periodos.iddia')
					->join('horas', 'periodos.idperiodo', '=', 'horas.idperiodo')
					->where('dias.idcancha', '=', $idcan)
					->select('dias.nombre', DB::raw('CONCAT(horas.horaingreso, " - ", horas.horasalida) as hora'), 'periodos.precio')->get();

		$alquileres = Alquiler::join('canchas', 'alquileres.idcancha', '=', 'canchas.idcancha')
						->where('alquileres.idcancha', '=', $idcan)
						->select('canchas.idcancha', 'alquileres.fecha', DB::raw('CONCAT(alquileres.horaingreso, " - ", alquileres.horasalida) as hora'), 'alquileres.estadohora')->get();

		$filas = '';
		for ($i=0; $i < 18; $i++) { 
			$filas = $filas . '<tr>';
			for ($j=0; $j < 7; $j++) {
				if ($i == 0) {
					if ($j == 0) {
						$filas = $filas . '<td class="text-center"><h3>Hora</h3></td>';
					}
					else{
						$dia = $this->sumarDiasFecha($fechaHoy, $j);
						$diames = date('d/m', strtotime($dia));
						$filas = $filas . '<td class="text-center"><h3>' . $this->dameNombreDia($dia) . ' ' . $diames . '</h3></td>';
					}
				}
				else{
					if ($j == 0) {
						switch ($i) {
							case 1:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">07:00 - 08:00</span></h4></td>';
							break;
							case 2:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">08:00 - 09:00</span></h4></td>';
							break;
							case 3:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">09:00 - 10:00</span></h4></td>';
							break;
							case 4:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">10:00 - 11:00</span></h4></td>';
							break;
							case 5:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">11:00 - 12:00</span></h4></td>';
							break;
							case 6:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">12:00 - 13:00</span></h4></td>';
							break;
							case 7:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">13:00 - 14:00</span></h4></td>';
							break;
							case 8:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">14:00 - 15:00</span></h4></td>';
							break;
							case 9:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">15:00 - 16:00</span></h4></td>';
							break;
							case 10:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">16:00 - 17:00</span></h4></td>';
							break;
							case 11:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">17:00 - 18:00</span></h4></td>';
							break;
							case 12:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">18:00 - 19:00</span></h4></td>';
							break;
							case 13:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">19:00 - 20:00</span></h4></td>';
							break;
							case 14:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">20:00 - 21:00</span></h4></td>';
							break;
							case 15:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">21:00 - 22:00</span></h4></td>';
							break;
							case 16:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">22:00 - 23:00</span></h4></td>';
							break;
							case 17:
								$filas = $filas . '<td class="text-center"><h4><span class="label label-primary">23:00 - 24:00</span></h4></td>';
							break;
						}
					}
					else{
						$dia = $this->sumarDiasFecha($fechaHoy, $j);
						$nombredia = $this->dameNombreDia($dia);
						$col = '';

						foreach ($atencion as $valor) {
							if ($valor->nombre == $nombredia) {
								switch ($valor->hora) {
									case '07:00 - 08:00':
										if ($i == 1) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													// La fecha del alquiler es igual a la fecha de hoy?
													if ($mifecha == $dia) {
														// La hora del alquiler es igual a esta hora?
														if ($alquiler->hora == '07:00 - 08:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '08:00 - 09:00':
										if ($i == 2) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '08:00 - 09:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '09:00 - 10:00':
										if ($i == 3) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '09:00 - 10:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '10:00 - 11:00':
										if ($i == 4) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '10:00 - 11:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '11:00 - 12:00':
										if ($i == 5) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '11:00 - 12:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '12:00 - 13:00':
										if ($i == 6) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '12:00 - 13:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '13:00 - 14:00':
										if ($i == 7) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '13:00 - 14:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '14:00 - 15:00':
										if ($i == 8) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '14:00 - 15:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '15:00 - 16:00':
										if ($i == 9) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '15:00 - 16:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '16:00 - 17:00':
										if ($i == 10) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '16:00 - 17:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '17:00 - 18:00':
										if ($i == 11) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '17:00 - 18:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '18:00 - 19:00':
										if ($i == 12) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '18:00 - 19:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '19:00 - 20:00':
										if ($i == 13) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '19:00 - 20:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '20:00 - 21:00':
										if ($i == 14) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '20:00 - 21:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '21:00 - 22:00':
										if ($i == 15) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '21:00 - 22:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '22:00 - 23:00':
										if ($i == 16) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '22:00 - 23:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
									case '23:00 - 24:00':
										if ($i == 17) {
											if (count($alquileres) > 0) {
												foreach ($alquileres as $alquiler) {
													$mifecha = date('d-m-Y', strtotime($alquiler->fecha));
													if ($mifecha == $dia) {
														if ($alquiler->hora == '23:00 - 24:00') {
															switch ($alquiler->estadohora) {
																case 'Reservado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-warning btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
																case 'Alquilado':
																	$col = '<td class="text-center"><input type="button" class="btn btn-danger btn3d" value="S/. ' . $valor->precio . '.00" disabled/></td>';
																break;
															}
															break;
														}
														else{
															if (Auth::check()){
																$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
															else{
																$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
															}
														}
													}
													else{
														if (Auth::check()){
															$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
														else{
															$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
														}
													}
												}
											}
											else{
												if (Auth::check()){
													$col = '<td class="text-center"><input onclick="realizarAlquiler()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
												else{
													$col = '<td class="text-center"><input onclick="necesitaLogueo()" type="button" class="btn btn-success btn3d" value="S/. ' . $valor->precio . '.00"/></td>';
												}
											}
										}
									break;
								}
							}
						}

						if ($col != '') {
							$filas = $filas . $col;
						}
						else{
							$filas = $filas . '<td class="text-center"></td>';
						}
					}
				}
				
			}
			$filas = $filas . '</tr>';
		}

		$tabla = $tabla . $filas;
		$tabla = $tabla . '</table>';
		
		return $tabla;
	}

	public function mostrarCanchas(){
		$idempresa = Auth::user()->idempresa;
		$canchas = Cancha::join('locales', 'canchas.idlocal', '=', 'locales.idlocal')
						->where('locales.idempresa', '=', $idempresa)
						->select('locales.nombre', 'canchas.idcancha', 'canchas.descripcion')->paginate(5);
		$locales = Local::select('idlocal', 'nombre')
						->where('idempresa', '=', $idempresa)->get();

		return View::make('administrador/miscanchas', array('canchas' => $canchas, 'locales' => $locales));
	}

	public function registrarCancha(){
		$data = Input::all();

		$cancha = new Cancha();

		$dataCancha = array('idlocal' => $data['cboLocal'], 'descripcion' => $data['txtDescripcionCancha']);

		$respuesta = $cancha->registrar($data, $dataCancha);

		if($respuesta['error'] == true){
			return Redirect::to('miscanchas')->withErrors($respuesta['mensaje'])->withInput();
		}
		else{
			return Redirect::to('miscanchas')->with('mensaje', $respuesta['mensaje']);
		}
	}
	
}


?>