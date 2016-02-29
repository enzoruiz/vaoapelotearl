<?php

class UsuarioController extends BaseController{

	public function mostrarUsuarios(){
		$usuEmpresas = Usuario::join('empresas', 'usuarios.idempresa', '=', 'empresas.idempresa')
							->where('usuarios.tipo', '=', 'Empresa')
							->select('empresas.razonsocial', 'usuarios.nombrecompleto', 'usuarios.dni', 'usuarios.email', 'usuarios.celular', 'usuarios.username')->paginate(5);
		$usuLocales = Usuario::join('locales', 'usuarios.idlocal', '=', 'locales.idlocal')
							->where('usuarios.tipo', '=', 'Local')
							->select('locales.nombre', 'usuarios.nombrecompleto', 'usuarios.dni', 'usuarios.email', 'usuarios.celular', 'usuarios.username')->paginate(5);
		$empresas = Empresa::select('idempresa', 'razonsocial')->get();
		$locales = Local::select('idlocal', 'nombre')->get();

		return View::make('intranet/losusuarios', array('usuEmpresas' => $usuEmpresas, 'usuLocales' => $usuLocales, 'empresas' => $empresas, 'locales' => $locales));
	}

	public function mostrarRegistro(){
		return View::make('cliente/registrousuario');
	}

	public function mostrarLogin(){
		return View::make('login');
	}

	public function registrarUsuario(){
		$data = Input::all();

		$usuario = new Usuario();
		$dataUsuario = array('idempresa' => $data['cboEmpresa'], 'idlocal' => $data['cboLocal'], 'tipo' => $data['cboTipo'], 'nombrecompleto' => $data['txtNombreCompleto'], 'dni' => $data['txtDniUsuario'], 'email' => $data['txtCorreoUsuario'], 'celular' => $data['txtCelularUsuario'], 'username' => $data['txtCorreoUsuario'], 'password' => Hash::make($data['txtDniUsuario']));
		$respuesta = $usuario->registrar($data, $dataUsuario);

		if($respuesta['error'] == true){
			return Redirect::to('losusuarios')->withErrors($respuesta['mensaje'])->withInput();
		}
		else{
			return Redirect::to('losusuarios')->with('mensaje', $respuesta['mensaje']);
		}
	}

	public function registroWeb(){
		$data = Input::all();

		if($data['terminos'] == 0){
			$respuesta = array();
			$respuesta['mensaje'] = "Debe Aceptar los Terminos y Condiciones.";
			return Redirect::to('registro')->withErrors($respuesta['mensaje'])->withInput();
		}
		else{
			$data['tipo'] = "Usuario";
			$data['idempresa'] = null;
			$data['idlocal'] = null;
			$data['foto'] = null;

			$usuario = new Usuario();
			$usuario->idempresa = $data['idempresa'];
			$usuario->idlocal = $data['idlocal'];
			$usuario->tipo = $data['tipo'];
			$usuario->nombrecompleto = $data['nombrecompleto'];
			$usuario->foto = $data['foto'];
			$usuario->dni = $data['dni'];
			$usuario->email = $data['email'];
			$usuario->celular = $data['celular'];
			$usuario->username = $data['username'];
			$respuesta = $usuario->registroWeb($data, $usuario);

			if($respuesta['error'] == true){
				return Redirect::to('registro')->withErrors($respuesta['mensaje'])->withInput();
			}
			else{
				return Redirect::to('registro')->with('mensaje', $respuesta['mensaje']);
			}
		}
	}

	public function login(){
		$data = Input::all();

		$reglas = array('inputUsernameEmail' => 'required', 'inputPassword' => 'required|min:6');
		$validator = Validator::make($data, $reglas);

		if ($validator->fails())
		{
			return Redirect::to('login')->withErrors($validator)->withInput();
		}
	 	
		$user = Usuario::where('email', '=', $data['inputUsernameEmail'])->orWhere('username', '=', $data['inputUsernameEmail'])->first();
	 
		if(!$user) {
			return Redirect::to('login')->withErrors(array('error_message' => 'Username/Email o Contraseña invalida.'))->withInput();
		} else {

			if( Auth::attempt(array('username' => $user->username, 'password' => $data['inputPassword']), true) ) {
				switch ($user->tipo) {
					case 'Master':
						$ruta = "/losusuarios";
					break;
					case 'Empresa':
						$ruta = "/misperiodos";
					break;
					case 'Local':
						$ruta = "/";
					break;
					case 'Usuario':
						$ruta = "/";
					break;
					default:
						$ruta = "/";
					break;
				}
				return Redirect::intended($ruta);
			}
			else{
				return Redirect::to('login')->withErrors(array('error_message' => 'Username/Email o Contraseña invalida.'))->withInput();
				}
		}	

	}

	public function loginFacebook(){
		$facebook = new Facebook(Config::get('facebook'));
	    $params = array(
	        'redirect_uri' => url('/login/fb/callback'),
	        'scope' => 'email'
	    );
	    return Redirect::to($facebook->getLoginUrl($params));
	}

	public function loginFacebookCallback(){
		$code = Input::get('code');
	    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');
	 
	    $facebook = new Facebook(Config::get('facebook'));
	    $uid = $facebook->getUser();
	 
	    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');
	 
	    $me = $facebook->api('/me');
	 
	    $profile = Perfil::whereUid($uid)->first();
	    if (empty($profile)) {

	        $user = new Usuario();
	        $user->idempresa = null;
	        $user->idlocal = null;
	        $user->tipo = 'Usuario';
	        $user->nombrecompleto = $me['first_name'].' '.$me['last_name'];
	        $user->foto = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
	        $user->dni = null;
	        $user->email = null;
	        $user->celular = null;
	        $user->username = $me['username'];
	        $user->password = Hash::make($me['username']);
	 
	        $user->save();

	        $profile = new Perfil();       
	        $profile->uid = $uid;
	        $profile->proviene = 'Facebook';
	        $profile->username = $me['username'];
	        $profile = $user->perfiles()->save($profile);
	    }
	 
	    $profile->access_token = $facebook->getAccessToken();
	    $profile->save();
	 
	    $user = $profile->usuario;
	 
	    Auth::login($user);
	 
	    return Redirect::to('/');
	}

	public function logout(){
		Auth::logout();
 
        return Redirect::to('/');
	}

}