<?php

class Cancha extends Eloquent{

	protected $fillable = array('idlocal', 'descripcion');

	public function alquileres(){
		return $this->hasMany('Alquiler', 'idcancha');
	}

	public function dias(){
		return $this->hasMany('Dia', 'idcancha');
	}

	public function local(){
		return $this->belongsTo('Local', 'idlocal');
	}

	public function registrar($data, $dataCancha){
		$respuesta = array();
        
        $reglas =  array(
            'cboLocal'  => array('required'),  
            'txtDescripcionCancha' => array('required')
        );
                
        $validator = Validator::make($data, $reglas);
        
        if ($validator->fails()){
            
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{

            $cancha = static::create($dataCancha);
            
            $respuesta['mensaje'] = 'Cancha registrada correctamente!';
            $respuesta['error']   = false;
        }     
        
        return $respuesta; 
	}

	public static function canchasLibres($nombre, $fecha, $hora){
		$sql = "SELECT DISTINCT c.idcancha, c.descripcion, p.precio FROM canchas c 
				INNER JOIN locales l ON c.idlocal = l.idlocal 
				INNER JOIN dias d ON c.idcancha = d.idcancha 
				INNER JOIN periodos p ON d.iddia = p.iddia 
				INNER JOIN horas h ON p.idperiodo = h.idperiodo 
				WHERE l.nombre = ? 
				AND d.nombre = CONCAT(ELT(WEEKDAY(?) + 1, 'Lunes', 'Martes', 'Miercoles', 'Juevez', 'Viernes', 'Sabado', 'Domingo')) 
				AND h.horaingreso = ? 
				AND c.idcancha NOT IN(
				    SELECT c.idcancha FROM canchas c 
				    INNER JOIN locales l ON c.idlocal = l.idlocal 
				    INNER JOIN alquileres a ON c.idcancha = a.idcancha 
				    WHERE l.nombre = ? 
				    AND a.fecha = ? 
				    AND a.horaingreso = ?
				)";
		return DB::select($sql, array($nombre, $fecha, $hora, $nombre, $fecha, $hora));
	}
	
	public static function localAtencion($fecha, $hora, $nombre){
		$sql = "SELECT count(c.idcancha) as cantidad FROM locales l 
				INNER JOIN canchas c ON l.idlocal = c.idlocal 
				INNER JOIN dias d ON c.idcancha = d.idcancha 
				INNER JOIN periodos p ON d.iddia = p.iddia 
				INNER JOIN horas h ON p.idperiodo = h.idperiodo 
				WHERE d.nombre = CONCAT(ELT(WEEKDAY(?) + 1, 'Lunes', 'Martes', 'Miercoles', 'Juevez', 'Viernes', 'Sabado', 'Domingo')) 
				AND h.horaingreso = ? 
				AND l.nombre = ?";
		return DB::select($sql, array($fecha, $hora, $nombre));
	}

	public static function localAtencionDistrito($fecha, $hora, $iddistrito){
		$sql = "SELECT DISTINCT l.nombre FROM locales l 
				INNER JOIN distritos di ON l.iddistrito = di.iddistrito 
				INNER JOIN canchas c ON l.idlocal = c.idlocal 
				INNER JOIN dias d ON c.idcancha = d.idcancha 
				INNER JOIN periodos p ON d.iddia = p.iddia 
				INNER JOIN horas h ON p.idperiodo = h.idperiodo 
				WHERE d.nombre = CONCAT(ELT(WEEKDAY(?) + 1, 'Lunes', 'Martes', 'Miercoles', 'Juevez', 'Viernes', 'Sabado', 'Domingo')) 
				AND h.horaingreso = ? 
				AND di.iddistrito = ?";
		return DB::select($sql, array($fecha, $hora, $iddistrito));
	}

}