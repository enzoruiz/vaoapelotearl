<?php

class EmpresaController extends BaseController{

	public function mostrarEmpresas(){
		$empresas = Empresa::join('distritos', 'empresas.iddistrito', '=', 'distritos.iddistrito')
					->join('provincias', 'distritos.idprovincia', '=', 'provincias.idprovincia')
					->select('empresas.razonsocial', 'provincias.nombre as provincia', 'distritos.nombre as distrito', 'empresas.direccion', 'empresas.telefono', 'empresas.correo')
					->paginate(5);
		return View::make('intranet/lasempresas', array('empresas' => $empresas));
	}

	public function registrarEmpresa(){
		$data = Input::all();
		$empresa = new Empresa();

		$dataEmpresa = array('iddistrito' => $data['cboDistritos'], 'razonsocial' => $data['txtRazonSocialEmpresa'], 'direccion' => $data['txtDireccionEmpresa'], 'telefono' => $data['txtTelefonoEmpresa'], 'correo' => $data['txtCorreoEmpresa']);

		$respuesta = $empresa->registrar($data, $dataEmpresa);

		if($respuesta['error'] == true){
			return Redirect::to('lasempresas')->withErrors($respuesta['mensaje'])->withInput();
		}
		else{
			return Redirect::to('lasempresas')->with('mensaje', $respuesta['mensaje']);
		}
	}

}