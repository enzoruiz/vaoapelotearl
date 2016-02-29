<?php

class Empresa extends Eloquent{

	protected $table = 'empresas';
	protected $fillable = array('iddistrito', 'razonsocial', 'direccion', 'telefono', 'correo');

	public function usuario(){
		return $this->hasOne('Usuario', 'idempresa');
	}

	public function locales(){
		return $this->hasMany('Local', 'idempresa');
	}

	public static function registrar($data, $dataEmpresa){
		// función que recibe como parámetro la información del formulario para crear la Empresa
        
        $respuesta = array();
        
        // Declaramos reglas para validar los parametros sean obligatorios y un correo valido
        $reglas =  array(
            'txtRazonSocialEmpresa'  => array('required', 'max:45'), 
            'cboDistritos' => array('required'), 
            'txtDireccionEmpresa' => array('required', 'max:45'), 
            'txtTelefonoEmpresa' => array('required', 'max:45'), 
            'txtCorreoEmpresa' => array('required', 'email', 'max:25')
        );
                
        $validator = Validator::make($data, $reglas);
        
        // verificamos que los datos cumplan la validación 
        if ($validator->fails()){
            
            // si no cumple las reglas se van a devolver los errores al controlador 
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{
        
            // en caso de cumplir las reglas se crea el objeto Empresa
            $empresa = static::create($dataEmpresa);        
            
            // se retorna un mensaje de éxito al controlador
            $respuesta['mensaje'] = 'Empresa registrada correctamente!';
            $respuesta['error']   = false;
        }     
        
        return $respuesta; 
	}

}