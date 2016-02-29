<?php
use Illuminate\Auth\UserInterface;

class Usuario extends Eloquent implements UserInterface{

	protected $fillable = array('idempresa', 'idlocal', 'tipo', 'nombrecompleto', 'foto', 'dni', 'email', 'celular', 'username', 'password');
    protected $primaryKey = "idusuario";

     public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    public function getAuthPassword()
    {
        return $this->password;
    }

	public function alquileres(){
		return $this->hasMany('Alquiler', 'idusuario');
	}

	public function empresa(){
		return $this->belongsTo('Empresa', 'idempresa');
	}

	public function local(){
		return $this->belongsTo('Local', 'idlocal');
	}

    public function perfiles(){
        return $this->hasMany('Perfil', 'idusuario');
    }

	public static function registrar($data, $dataUsuario){        
        $respuesta = array();
        
        $reglas =  array(
            'txtNombreCompleto'  => array('required', 'max:45'),  
            'txtDniUsuario' => array('required', 'numeric'),
            'txtCorreoUsuario' => array('required', 'email'),
            'txtCelularUsuario' => array('required', 'max:45')
        );
                
        $validator = Validator::make($data, $reglas);
        
        if ($validator->fails()){
            
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{

            $usuario = static::create($dataUsuario);
            
            $respuesta['mensaje'] = 'Usuario registrado correctamente!';
            $respuesta['error']   = false;
        }     
        
        return $respuesta; 
	}

    public function registroWeb($data, $usuario){        
        $respuesta = array();
        
        $reglas =  array(
            'nombrecompleto'  => array('required', 'max:45'),  
            'dni' => array('required', 'numeric', 'unique:usuarios,dni'),
            'email' => array('required', 'email', 'unique:usuarios,email'),
            'celular' => array('required', 'numeric'),
            'username' => array('required', 'alpha_num', 'unique:usuarios,username', 'between:5,15'),
            'password' => array('required', 'confirmed','alpha_num', 'between:8,18'),
            'password_confirmation' => array('required', 'alpha_num', 'between:8,18')
        );
                
        $validator = Validator::make($data, $reglas);
        
        if ($validator->fails()){
            
            $respuesta['mensaje'] = $validator;
            $respuesta['error']   = true;
        }else{
            $usuario->password = Hash::make($data['password']);
            $usuario->save();
            $perfil = new Perfil();
            $perfil->username = $data['username'];
            $perfil->uid = null;
            $perfil->access_token = null;
            $perfil->access_token_secret = null;
            $perfil = $usuario->perfiles()->save($perfil);
            $perfil->save();
        
            $respuesta['mensaje'] = 'Usuario registrado correctamente!';
            $respuesta['error']   = false;
            $respuesta['data']    = $usuario;
        }     
        
        return $respuesta; 
    }



}