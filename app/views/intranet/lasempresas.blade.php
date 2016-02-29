@extends('plantilla')

@section('titulo')
	Reserva tu cancha y Vao a Pelotear!
@stop

@section('files-css')
	{{ HTML::style('assets/css/sidebar-left.css', array('media' => 'screen')) }}
@stop

@section('navbar')
	</ul>
	@if(Auth::check())
    <ul class="nav navbar-nav navbar-right">
      	<li class="dropdown">
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> {{ Auth::user()->username }}</a>
        	<ul class="dropdown-menu">
          		<li><a href="#">Mis Reservas</a></li>
          		<li><a href="#">Mis Puntos</a></li>
          		<li><a href="#">Editar Perfil</a></li>
          		<li class="divider"></li>
          		<li><a href="{{ URL::to('logout') }}"><i class="glyphicon glyphicon-off"></i> Cerrar Sesion</a></li>
        	</ul>
      	</li>
    </ul>
  	@else
    	{{ Form::button('Ingresa', array('class' => 'navbar-right btn btn-primary btn-sm btn3dMargin', 'data-toggle' => 'modal', 'data-target' => '#modal-ingreso')) }}
  	@endif
@stop

@section('cuerpo')
	<div class="container">
		<br><br><br>
		<div class="row">
			<div class="col-md-12">
				<div id="wrapper" class="active">
      
			      	{{-- Sidebar --}}
			            {{-- Sidebar --}}
			      	<div id="sidebar-wrapper">
			      		<ul id="sidebar_menu" class="sidebar-nav">
			           		<li class="sidebar-brand"><a id="menu-toggle" href="#">Menu<span id="main_icon" class="glyphicon glyphicon-align-justify"></span></a></li>
			      		</ul>
			        	<ul class="sidebar-nav" id="sidebar">     
			          		<li><a href="{{ URL::to('losusuarios') }}">Los Usuarios<span class="sub_icon glyphicon glyphicon-user"></span></a></li>
			          		<li><a href="{{ URL::to('lasempresas') }}">Las Empresas<span class="sub_icon glyphicon glyphicon-bookmark"></span></a></li>
			          		<li><a href="{{ URL::to('loslocales') }}">Los Locales<span class="sub_icon glyphicon glyphicon-tag"></span></a></li>
			        	</ul>
			      	</div>
			        
			      	{{-- Page content --}}
			      	<div id="page-content-wrapper">
			        	{{-- Keep all page content within the page-content inset div! --}}
			        	<div class="page-content inset">
			          		<div class="row">
			              		<div class="col-xs-12 col-md-12">
			              			<div class="jumbotron">
			              				<h1 align="center">Empresas</h1>
			              			</div>
			              			<div class="row">
			              				<div class="col-md-12">
			              					<div class="table-responsive">
			              						@if (count($empresas) > 0)
													<table class="table table-bordered">
														<tr>
							              					<th>Razon Social</th>
							              					<th>Provincia</th>
							              					<th>Distrito</th>
							              					<th>Dirección</th>
							              					<th>Telefono</th>
							              					<th>Correo</th>
							              				</tr>
							              				@foreach ($empresas as $empresa)
							              					<tr>
								              					<td>{{ $empresa->razonsocial }}</td>
								              					<td>{{ $empresa->provincia }}</td>
								              					<td>{{ $empresa->distrito }}</td>
								              					<td>{{ $empresa->direccion }}</td>
								              					<td>{{ $empresa->telefono }}</td>
								              					<td>{{ $empresa->correo }}</td>
								              				</tr>
							              				@endforeach
							              			</table>
							              			<div align="center">
							              				{{ $empresas->links() }}
							              			</div>
						              			@else	
													<div class="alert alert-info">No hay empresas registradas.</div>
						              			@endif
			              					</div>
				              			</div>
			              			</div>
			              			<hr>
			              			<div class="row">
			              				<div class="col-md-2"></div>
			              				<div class="col-md-8">
											@if (Session::get('mensaje'))
												<div class="alert alert-success fade in">
													<button class="close" data-dismiss="alert" href="#" aria-hidden="true">x</button>
													{{ Session::get('mensaje') }}
												</div>
											@endif
											@if ($errors->any())
												<div class="alert alert-danger fade in">
													<button class="close" data-dismiss="alert" href="#" aria-hidden="true">x</button>
													<strong>Por favor corrige los siguentes errores:</strong>
												    <ul>
													    @foreach ($errors->all() as $error)
													    	<li>{{ $error }}</li>
													    @endforeach
												    </ul>
												</div>
											@endif
			              					<div class="well">
					              				<legend><h3>Nueva Empresa</h3></legend>
					              				{{ Form::open(array('url' => 'lasempresas', 'method' => 'POST', 'class' => 'form-horizontal')) }}
					              					<div class="form-group">
					              						{{ Form::label('razonsocial', 'Razon Social: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{Form::text('txtRazonSocialEmpresa', '', array('class' => 'form-control', 'id' => 'txtRazonSocialEmpresa', 'required', 'autofocus'))}}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('departamento', 'Departamento: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							<select id="cboDepartamentos" class="form-control" style="width:170px;" required>
									                          	<option value="">DEPARTAMENTO</option>
									                        </select>
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('provincia', 'Provincia: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							<select id="cboProvincias" class="form-control" style="width:170px;" required>
									                          	<option value="">PROVINCIA</option>
									                        </select>
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('distrito', 'Distrito: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							<select name="cboDistritos" id="cboDistritos" class="form-control" style="width:170px;" required>
									                          	<option value="">DISTRITO</option>
									                        </select>
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('direccion', 'Dirección: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::text('txtDireccionEmpresa', '', array('class' => 'form-control', 'id' => 'txtDireccionEmpresa', 'required')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('telefono', 'Telefono: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::text('txtTelefonoEmpresa', '', array('class' => 'form-control', 'id' => 'txtTelefonoEmpresa', 'required')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('correo', 'Correo: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::text('txtCorreoEmpresa', '', array('type' => 'email', 'class' => 'form-control', 'id' => 'txtCorreoEmpresa', 'required')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						<div class="col-md-offset-3 col-md-9">
					              							{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('type' => 'submit', 'id' => 'btnRegistrarEmpresa', 'class' => 'btn btn-default btn3d')) }}
					              							{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Limpiar', array('type' => 'reset', 'id' => 'btnLimpiar', 'class' => 'btn btn-default btn3d')) }}
					              						</div>
					              					</div>
					              				{{ Form::close() }}
					              			</div>
			              				</div>
			              				<div class="col-md-2"></div>
			              			</div>
			            		</div>
			            		{{-- FOOTER --}}
			            		<div class="col-xs-12 col-sm-12">
									<footer>
										<div class="well">FOOTER</div>
									</footer>
								</div>
								{{-- /FOOTER --}}
			          		</div>
			        	</div>
			      	</div>
			      
			    </div>
			</div>
		</div>
	</div>
@stop

@section('files-js')
	{{ HTML::script('assets/js/lugares.js') }}
@stop