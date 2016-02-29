<?php

class Periodo extends Eloquent{

	protected $fillable = array('iddia', 'horainicio', 'horafin', 'precio');
	protected $primaryKey = "idperiodo";

	public function horas(){
		return $this->hasMany('Hora', 'idperiodo');
	}

	public function dia(){
		return $this->belongsTo('Dia', 'iddia');
	}

	public static function validarCrucePeriodo($nomDia, $idcan, $horainicio, $horafin){
		// si la cantidad que regresa es mayor a 0 es porque hay cruce
		$sql = "SELECT count(DISTINCT p.idperiodo) as cantidad FROM canchas c 
				INNER JOIN dias d ON c.idcancha = d.idcancha 
				INNER JOIN periodos p ON d.iddia = p.iddia 
				INNER JOIN horas h ON p.idperiodo = h.idperiodo 
				WHERE d.nombre = ? 
				AND c.idcancha = ? 
				AND (
					((? > p.horainicio AND ? < p.horafin) OR (? > p.horainicio AND ? < p.horafin)) 
				OR 
				((p.horainicio >= ? AND p.horainicio <= ?) OR (p.horafin >= ? AND p.horafin <= ?))
					)";
		$consulta = DB::select($sql, array($nomDia, $idcan, $horainicio, $horainicio, $horafin, $horafin, $horainicio, $horafin, $horainicio, $horafin));
		$can = $consulta[0]->cantidad;
		$res = true;
		if($can > 0){
			$res = false;
		}
		return $res;
	}
	
	public static function registrar($data, $dias){

		$respuesta = array();
        
        $reglas =  array(
            'cboLocal'  => array('required'), 
            'cboCancha' => array('required'), 
            'cboHoraInicio' => array('required'), 
            'cboHoraFin' => array('required'), 
            'txtPrecioPeriodo' => array('required')
        );
                
        $validator = Validator::make($data, $reglas);
        
        if ($validator->fails()){
            
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{

        	$can = count($dias);
        	for ($i=0; $i < $can; $i++) { 
        		$nuevoDia = new Dia();
	       		$nuevoDia->idcancha = $data['cboCancha'];
	       		$nuevoDia->nombre = $dias[$i];
	       		$nuevoDia->save();
	       		$nuevoPeriodo = new Periodo();
	       		$nuevoPeriodo->horainicio = $data['cboHoraInicio'];
	       		$nuevoPeriodo->horafin = $data['cboHoraFin'];
	       		$nuevoPeriodo->precio = $data['txtPrecioPeriodo'];
	       		$nuevoPeriodo = $nuevoDia->periodos()->save($nuevoPeriodo);
	       		$nuevoPeriodo->save();

	       		$hi = date('H:i', strtotime($data['cboHoraInicio']));
				$hf = date('H:i', strtotime($data['cboHoraFin']));

				while ($hi < $hf) {
					$h = date('H:i', strtotime('+1 hour', strtotime($hi)));

					$nuevaHora = new Hora();
					$nuevaHora->horaingreso = $hi;
					$nuevaHora->horasalida = $h;
					$nuevaHora = $nuevoPeriodo->horas()->save($nuevaHora);
					$nuevaHora->save();

					$hi = date('H:i', strtotime('+1 hour', strtotime($hi)));
				}
        	}      
            
            $respuesta['mensaje'] = 'Periodo registrado correctamente!';
            $respuesta['error']   = false;
        }     
        
        return $respuesta; 
	}

}