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
			              				<h1 align="center">Periodos</h1>
			              			</div>
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
												<legend><h3>Nuevo Periodo</h3></legend>
													{{ Form::open(array('url' => 'misperiodos', 'id' => 'frmPeriodos', 'name' => 'frmPeriodos', 'method' => 'POST', 'class' => 'form-horizontal')) }}
													<div class="form-group">
						              					{{ Form::label('cboLocal', 'Local: ', array('class' => 'col-md-3 control-label')) }}
						              					<div class="col-md-9">
						              						<select name="cboLocal" id="cboLocal" class="form-control" onchange="dameCanchas()" required>
						              							<option value="">Selecciona Local</option>
						              							@foreach ($locales as $local)
						              								<option value="{{ $local->idlocal }}">{{ $local->nombre }}</option>
						              							@endforeach
						              						</select>
						              					</div>
						              				</div>
						              				<div class="form-group">
					              						{{ Form::label('cancha', 'Cancha: ', array('class' => 'col-md-3 control-label')) }}
					              						<div class="col-md-9">
					              							<select name="cboCancha" id="cboCancha" class="form-control" style="width:150px;" required>
									                          	<option value="">Cancha</option>
									                        </select>
					              						</div>
					              					</div>
					              					<div class="form-group">
					              						{{ Form::label('dias', 'Dia(s): ', array('class' => 'col-md-3 control-label')) }}
														<div class="col-md-7">
															<label class="checkbox-inline">
																{{Form::checkbox('chkLunes', 'Lunes', false, array('id' => 'chkLunes'))}}Lunes
															</label>
															<label class="checkbox-inline">
																{{Form::checkbox('chkMartes', 'Martes', false, array('id' => 'chkMartes'))}}Martes
															</label>
															<label class="checkbox-inline">
																{{Form::checkbox('chkMiercoles', 'Miercoles', false, array('id' => 'chkMiercoles'))}}Miercoles
															</label>
															<label class="checkbox-inline">
																{{Form::checkbox('chkJueves', 'Jueves', false, array('id' => 'chkJueves'))}}Jueves
															</label>
															<label class="checkbox-inline">
																{{Form::checkbox('chkViernes', 'Viernes', false, array('id' => 'chkViernes'))}}Viernes
															</label>
															<label class="checkbox-inline">
																{{Form::checkbox('chkSabado', 'Sabado', false, array('id' => 'chkSabado'))}}Sabado
															</label>
															<label class="checkbox-inline">
																{{Form::checkbox('chkDomingo', 'Domingo', false, array('id' => 'chkDomingo'))}}Domingo
															</label>
						              					</div>
					              					</div>
													<div class="form-group">
														{{ Form::label('horaInicio', 'Hora de Inicio: ', array('class' => 'col-md-3 control-label')) }}
														<div class="col-md-9">
						              						{{ Form::select('cboHoraInicio', array(1 => '07:00', 2 => '08:00', 3 => '09:00', 4 => '10:00', 5 => '11:00', 6 => '12:00', 7 => '13:00', 8 => '14:00', 9 => '15:00', 10 => '16:00', 11 => '17:00', 12 => '18:00', 13 => '19:00', 14 => '20:00', 15 => '21:00', 16 => '22:00'), 1, array('class' => 'form-control', 'id' => 'cboHoraInicio', 'style' => 'width:100px;', 'required')) }}
						              					</div>
													</div>
													<div class="form-group">
														{{ Form::label('horaFin', 'Hora de Fin: ', array('class' => 'col-md-3 control-label')) }}
														<div class="col-md-9">
						              						{{ Form::select('cboHoraFin', array(2 => '08:00', 3 => '09:00', 4 => '10:00', 5 => '11:00', 6 => '12:00', 7 => '13:00', 8 => '14:00', 9 => '15:00', 10 => '16:00', 11 => '17:00', 12 => '18:00', 13 => '19:00', 14 => '20:00', 15 => '21:00', 16 => '22:00', 17 => '23:00'), 1, array('class' => 'form-control', 'id' => 'cboHoraFin', 'style' => 'width:100px;', 'required')) }}
						              					</div>
													</div>
													<div class="form-group">
														{{ Form::label('precioPeriodo', 'Precio: ', array('class' => 'col-md-3 control-label')) }}
														<div class="col-md-9">
						              						{{ Form::text('txtPrecioPeriodo', '', array('id' => 'txtPrecioPeriodo', 'class' => 'form-control', 'style' => 'width:100px;', 'required')) }}
						              					</div>
													</div>
													<div class="form-group">
					              						<div class="col-md-offset-3 col-md-9">
					              							{{ Form::button('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar', array('type' => 'submit', 'id' => 'btnRegistrarPeriodo', 'class' => 'btn btn-default btn3d')) }}
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
	{{ HTML::script('assets/js/periodo.js') }}
@stop