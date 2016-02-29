<?php

class Local extends Eloquent{

	protected $table = 'locales';
    protected $fillable = array('idempresa', 'iddistrito', 'nombre', 'direccion', 'telefono', 'servicios','fotoprincipal', 'foto2', 'foto3');
	protected $guarded = array('calificacion');

	public function usuario(){
		return $this->hasOne('Usuario', 'idlocal');
	}

	public function empresa(){
		return $this->belongsTo('Empresa', 'idempresa');
	}

	public function canchas(){
		return $this->hasMany('Cancha', 'idlocal');
	}

	public static function registrar($data, $local){
		// función que recibe como parámetro la información del formulario para crear la Local
        
        $respuesta = array();
        
        // Declaramos reglas para validar los parametros sean obligatorios
        $reglas =  array(
            'txtNombreLocal'  => array('required', 'max:45'), 
            'cboDistritos' => array('required'),
            'txtDireccionLocal' => array('required', 'max:45'),
            'txtTelefonoLocal' => array('required', 'max:45'),
            'txtServiciosLocal' => array('required'),
            'fileFotoPrincipal' => array('required', 'image', 'max:2000'),
            'fileFoto2' => array('required', 'image', 'max:2000'),
            'fileFoto3' => array('required', 'image', 'max:2000')
        );
                
        $validator = Validator::make($data, $reglas);
        
        // verificamos que los datos cumplan la validación 
        if ($validator->fails()){
            
            // si no cumple las reglas se van a devolver los errores al controlador 
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{
        
            // en caso de cumplir las reglas se crea el objeto Local

            $local = static::create($local);        
            
            // se retorna un mensaje de éxito al controlador
            $respuesta['mensaje'] = 'Local registrado correctamente!';
            $respuesta['error']   = false;
        }     
        
        return $respuesta; 
	}

}