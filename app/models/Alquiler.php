<?php

class Alquiler extends Eloquent{

	protected $table = 'alquileres';
	protected $fillable = array('idusuario', 'idcancha', 'estadoalquiler', 'fecha', 'horaingreso', 'horasalida', 'estadohora', 'monto');

	public function usuario(){
		return $this->belongsTo('Usuario', 'idusuario');
	}

	public function cancha(){
		return $this->belongsTo('Cancha', 'idcancha');
	}

	public static function registrar($data, $dataAlquiler){
		// función que recibe como parámetro la información del formulario para validar y crear el Alquiler
        
        $respuesta = array();
        
        // declaramos reglas para validar los parametros
        $reglas =  array(
            'txtCancha'  => array('required')
        );
                
        $validator = Validator::make($data, $reglas);
        
        // verificamos que los datos cumplan la validación 
        if ($validator->fails()){
            
            // si no cumple las reglas se van a devolver los errores al controlador 
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{
        
            // en caso de cumplir las reglas se crea el alquiler
            $alquiler = static::create($dataAlquiler);        
            
            // se retorna un mensaje de éxito al controlador
            $respuesta['mensaje'] = 'Alquiler registrado correctamente!';
            $respuesta['error']   = false;
        }     
        
        return $respuesta; 
	}

}