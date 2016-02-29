<?php

class LocalController extends BaseController{

	public function mostrarLocales(){
		$locales = Local::join('empresas', 'locales.idempresa', '=', 'empresas.idempresa')
		->join('distritos', 'locales.iddistrito', '=', 'distritos.iddistrito')
		->join('provincias', 'distritos.idprovincia', '=', 'provincias.idprovincia')
		->select('empresas.razonsocial as razonSocial', 'locales.nombre as nombreLocal', 'provincias.nombre as provincia', 'distritos.nombre as distrito', 'locales.direccion', 'locales.telefono')->paginate(5);
		$empresas = Empresa::select('idempresa', 'razonsocial')->get();

		return View::make('intranet/loslocales', array('locales' => $locales, 'empresas' => $empresas));
	}

	public function registrarLocal(){
		$data = Input::all();
		$local = new Local();
		$dataLocal = array('idempresa' => $data['cboEmpresa'], 'iddistrito' => $data['cboDistritos'], 'nombre' => $data['txtNombreLocal'], 'direccion' => $data['txtDireccionLocal'], 'telefono' => $data['txtTelefonoLocal'], 'servicios' => $data['txtServiciosLocal'], 'fotoprincipal' => Input::file('fileFotoPrincipal')->getClientOriginalName(), 'foto2' => Input::file('fileFoto2')->getClientOriginalName(), 'foto3' => Input::file('fileFoto3')->getClientOriginalName());
		
		$respuesta = $local->registrar($data, $dataLocal);

		if($respuesta['error'] == true){
			return Redirect::to('loslocales')->withErrors($respuesta['mensaje'])->withInput();
		}
		else{
			$destinationPath = 'assets/img/'.$data['txtNombreLocal'].'_'.$data['txtDireccionLocal'];

            $file = Input::file('fileFotoPrincipal');
            $filename = $file->getClientOriginalName();
            Input::file('fileFotoPrincipal')->move($destinationPath, $filename);

            $file = Input::file('fileFoto2');
            $filename = $file->getClientOriginalName();
            Input::file('fileFoto2')->move($destinationPath, $filename);

            $file = Input::file('fileFoto3');
            $filename = $file->getClientOriginalName();
            Input::file('fileFoto3')->move($destinationPath, $filename);

			return Redirect::to('loslocales')->with('mensaje', $respuesta['mensaje']);
		}
	}

}