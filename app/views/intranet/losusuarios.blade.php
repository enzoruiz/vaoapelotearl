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
			              				<h1 align="center">Usuarios</h1>
			              			</div>
									<div class="row">
			              				<div class="col-md-12">
			              					<div class="table-responsive">
			              						@if (count($usuEmpresas) > 0)
			              							<legend><h3>Usuarios de Empresas</h3></legend>
													<table class="table table-bordered">
														<tr>
							              					<th>Empresa</th>
							              					<th>Nombre Completo</th>
							              					<th>Dni</th>
							              					<th>Correo</th>
							              					<th>Celular</th>
							              					<th>Username</th>
							              				</tr>
							              				@foreach ($usuEmpresas as $usuEmpresa)
							              					<tr>
								              					<td>{{ $usuEmpresa->razonsocial }}</td>
								              					<td>{{ $usuEmpresa->nombrecompleto }}</td>
								              					<td>{{ $usuEmpresa->dni }}</td>
								              					<td>{{ $usuEmpresa->email }}</td>
								              					<td>{{ $usuEmpresa->celular }}</td>
								              					<td>{{ $usuEmpresa->username }}</td>
								              				</tr>
							              				@endforeach
							              			</table>
							              			<div align="center">
							              				{{ $usuEmpresas->links() }}
							              			</div>
						              			@else	
													<div class="alert alert-info">No hay usuarios de Empresas registrados.</div>
						              			@endif
			              					</div>
				              			</div>
				              			<div class="col-md-12">
			              					<div class="table-responsive">
			              						@if (count($usuLocales) > 0)
			              							<legend><h3>Usuarios de Locales</h3></legend>
													<table class="table table-bordered">
														<tr>
							              					<th>Local</th>
							              					<th>Nombre Completo</th>
							              					<th>Dni</th>
							              					<th>Correo</th>
							              					<th>Celular</th>
							              					<th>Username</th>
							              				</tr>
							              				@foreach ($usuLocales as $usuLocal)
							              					<tr>
								              					<td>{{ $usuLocal->nombre }}</td>
								              					<td>{{ $usuLocal->nombrecompleto }}</td>
								              					<td>{{ $usuLocal->dni }}</td>
								              					<td>{{ $usuLocal->email }}</td>
								              					<td>{{ $usuLocal->celular }}</td>
								              					<td>{{ $usuLocal->username }}</td>
								              				</tr>
							              				@endforeach
							              			</table>
							              			<div align="center">
							              				{{ $usuLocales->links() }}
							              			</div>
						              			@else	
													<div class="alert alert-info">No hay usuarios de Locales registrados.</div>
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
					              				<legend><h3>Nuevo Usuario</h3></legend>
					              				{{ Form::open(array('url' => 'losusuarios', 'method' => 'POST', 'class' => 'form-horizontal')) }}
					              					<div class="form-group">
					              						{{ Form::label('empresa', 'Empresa: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							<select name="cboEmpresa" id="cboEmpresa" class="form-control">
					              								<option value="null" selected>Empresa</option>
					              								@foreach ($empresas as $empresa)
					              									<option value="{{ $empresa->idempresa }}">{{ $empresa->razonsocial }}</option>
					              								@endforeach
					              							</select>
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('local', 'Local: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							<select name="cboLocal" id="cboLocal" class="form-control">
					              								<option value="null" selected>Local</option>
					              								@foreach ($locales as $local)
					              									<option value="{{ $local->idlocal }}">{{ $local->nombre }}</option>
					              								@endforeach
					              							</select>
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('tipo', 'Tipo: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::select('cboTipo', array('Usuario' => 'Usuario', 'Empresa' => 'Empresa', 'Local' => 'Local'), 'Usuario', array('class' => 'form-control', 'id' => 'cboTipo', 'style' => 'width:170px;')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('nombre', 'Nombre Completo: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{Form::text('txtNombreCompleto', '', array('class' => 'form-control', 'id' => 'txtNombreCompleto', 'required'))}}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('dniUsuario', 'Dni: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::text('txtDniUsuario', '', array('class' => 'form-control', 'id' => 'txtDniUsuario', 'required', 'style' => 'width:140px;', 'maxlength' => '8')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('correoUsuario', 'Correo: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::text('txtCorreoUsuario', '', array('type' => 'email', 'class' => 'form-control', 'id' => 'txtCorreoUsuario', 'required')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('celularUsuario', 'Celular: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							{{ Form::text('txtCelularUsuario', '', array('class' => 'form-control', 'id' => 'txtCelularUsuario', 'required', 'style' => 'width:140px;')) }}
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						<div class="col-md-offset-3 col-md-9">
					              							{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('type' => 'submit', 'id' => 'btnRegistrarUsuario', 'class' => 'btn btn-default btn3d')) }}
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