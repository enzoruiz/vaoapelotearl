@extends('plantilla')

@section('titulo')
	Reserva tu cancha y Vao a Pelotear!
@stop

@section('files-css')
	{{ HTML::style('assets/css/registrousuario.css', array('media' => 'screen')) }}
@stop

@section('navbar')
		<li><a href="#">Premios</a></li>
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
		<div class="row">
			<div class="col-sm-12">
				<br><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="well">
					<div class="row">

						{{ Form::open(array('url' => 'canchanombre', 'method' => 'POST')) }}
							<div class="col-xs-12 col-sm-12 col-md-2" align="center" style="padding-top:11px;">
								{{Form::button('<span class="glyphicon glyphicon-ok"></span> Mi Cancha Preferida', array('type' => 'submit', 'class' => 'btn btn-default btn-md btn3d', 'id' => 'btnBuscarCancha', 'onclick' => 'mostrar1()'))}}
								<br>
								<br>
                  				{{Form::button('<span class="glyphicon glyphicon-map-marker"></span> Canchas Disponibles', array('type' => 'submit', 'class' => 'btn btn-default btn-md btn3d', 'id' => 'btnBuscarCancha', 'onclick' => 'mostrar2()'))}}
							</div>
		                    <div class="col-xs-12 col-sm-12 col-md-10">
		                      	<div id="mostrarBoton1">
				                	{{ Form::open(array('url' => 'canchanombre', 'method' => 'POST')) }}
				                    	<div class="col-xs-12 col-sm-12 col-md-10">
				                      		<div align="left" class="input-group">
				                        		{{ Form::text('txtBusquedaCancha', null, array('class' => 'input-lg form-control typeahead tt-query', 'id' => 'txtBusquedaCancha', 'placeholder' => 'Nombre de Cancha', 'size' => '120', 'required' => 'required')) }}
				                      		</div>
				                      		<br>
				                        	<div align="right" class="form-group col-xs-6 col-sm-6 col-md-6" >
					                          	<div class="input-group">
					                            	{{ Form::text('dpcalendario', null, array('class' => 'form-control', 'id' => 'dpcalendario', 'readonly' => 'true', 'style' => 'width:120px;')) }}
					                            	<span class="input-group-addon glyphicon glyphicon-calendar"></span>
					                          	</div>
				                        	</div>
				                        	<div align="left" class="form-group col-xs-6 col-sm-6 col-md-6">
				                          		<div class="input-group">
				                            		{{ Form::select('cboHoraCancha', array('07:00 - 08:00' => '07:00 - 08:00', '08:00 - 09:00' => '08:00 - 09:00', '09:00 - 10:00' => '09:00 - 10:00', '10:00 - 11:00' => '10:00 - 11:00', '11:00 - 12:00' => '11:00 - 12:00', '12:00 - 13:00' => '12:00 - 13:00', '13:00 - 14:00' => '13:00 - 14:00', '14:00 - 15:00' => '14:00 - 15:00', '15:00 - 16:00' => '15:00 - 16:00', '16:00 - 17:00' => '16:00 - 17:00', '17:00 - 18:00' => '17:00 - 18:00', '18:00 - 19:00' => '18:00 - 19:00', '19:00 - 20:00' => '19:00 - 20:00', '20:00 - 21:00' => '20:00 - 21:00', '21:00 - 22:00' => '21:00 - 22:00', '22:00 - 23:00' => '22:00 - 23:00'), '09:00 - 10:00', array('class' => 'form-control', 'id' => 'cboHoraCancha', 'style' => 'width:140px;')) }}
				                          		</div>
				                        	</div>
				                    	</div>
				                    	<div class="col-xs-12 col-sm-12 col-md-2" align="center">
				                      		<br>
				                      		{{Form::button('<span class="glyphicon glyphicon-search"></span> Buscar!', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn3d', 'id' => 'btnBuscarCancha1'))}}
				                    	</div>
				                  	{{ Form::close() }}
				                </div>
				                <div id="mostrarBoton2">
				                  	{{ Form::open(array('url' => 'canchaslugar', 'method' => 'POST', 'role' => 'form', 'class' => 'form-inline')) }}
				                    	<div align="center" class="col-xs-12 col-sm-12 col-md-10">
				                      		<div class="form-group">
				                        		<select id="cboDepartamentos" class="form-control" style="width:170px;" required>
				                          			<option value="">DEPARTAMENTO</option>
				                        		</select>
				                      		</div>
				                      		<div class="form-group">
				                        		<select id="cboProvincias" class="form-control" style="width:170px;" required>
				                          			<option value="">PROVINCIA</option>
				                        		</select>
				                      		</div>
				                      		<div class="form-group">
				                        		<select name="cboDistritos" id="cboDistritos" class="form-control" style="width:170px;" required>
				                          			<option value="">DISTRITO</option>
				                        		</select>
				                      		</div>
				                      		<div class="form-group">
				                        		<div class="input-group">
				                          			{{ Form::text('dpcalendario2', null, array('class' => 'form-control', 'id' => 'dpcalendario2', 'readonly' => 'true', 'style' => 'width:120px;')) }}
				                          			<span class="input-group-addon glyphicon glyphicon-calendar"></span>
				                        		</div>
				                      		</div>
				                      		<div class="form-group">
				                        		{{ Form::select('cboHoraCancha', array('07:00 - 08:00' => '07:00 - 08:00', '08:00 - 09:00' => '08:00 - 09:00', '09:00 - 10:00' => '09:00 - 10:00', '10:00 - 11:00' => '10:00 - 11:00', '11:00 - 12:00' => '11:00 - 12:00', '12:00 - 13:00' => '12:00 - 13:00', '13:00 - 14:00' => '13:00 - 14:00', '14:00 - 15:00' => '14:00 - 15:00', '15:00 - 16:00' => '15:00 - 16:00', '16:00 - 17:00' => '16:00 - 17:00', '17:00 - 18:00' => '17:00 - 18:00', '18:00 - 19:00' => '18:00 - 19:00', '19:00 - 20:00' => '19:00 - 20:00', '20:00 - 21:00' => '20:00 - 21:00', '21:00 - 22:00' => '21:00 - 22:00', '22:00 - 23:00' => '22:00 - 23:00'), '09:00 - 10:00', array('class' => 'form-control', 'id' => 'cboHoraCancha', 'style' => 'width:140px;')) }}
				                      		</div>
				                    	</div>
				                    	<div class="col-xs-12 col-sm-12 col-md-2" align="center">
				                      		{{Form::button('<span class="glyphicon glyphicon-search"></span> Buscar!', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn3d', 'id' => 'btnBuscarCancha2'))}}
				                    	</div>
				                  	{{ Form::close() }}
				                </div>
		                    </div>
		                {{ Form::close() }}
							
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div class="col-xs-12 col-sm-12 col-md-12">
                  	<div class="well">
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
                  		{{ Form::open(array('url' => 'login', 'method' => 'POST', 'role' => 'form')) }}
		                    <fieldset>
		                       	<h2 class="text-center"><strong>Registrate ahora y te regalamos 1000 puntos de bienvenida!</strong></h2>
		                       	<div class="row">
			                       	<div class="col-xs-6 col-sm-6 col-md-6">
			                       		<a href="#" class="btn btn-lg btn-primary btn-block">Facebook</a>
			                       	</div>
			                       	<div class="col-xs-6 col-sm-6 col-md-6">
			                       		<a href="#" class="btn btn-lg btn-info btn-block">Google</a>
			                      	</div>
		                       	</div>
		                       	<br>
		                       	<hr class="colorgraph">
			                    <div class="form-group">
			                	   	{{ Form::text('inputUsernameEmail', null, array('id' => 'inputUsernameEmail', 'class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Username o Email')) }}
			                    </div>
			                    <div class="form-group">
			                      	{{ Form::password('inputPassword', array('id' => 'inputPassword', 'class' => 'form-control input-lg', 'required' => 'required', 'placeholder' => 'Contraseña')) }}
			                    </div>
			                    <div class="form-group">
			                      	<a href="{{ URL::to('registro') }}" class="btn btn-link pull-left">Aun no tienes cuenta?</a>
			                      	<a href="" class="btn btn-link pull-right">Olvidaste tu contraseña?</a>
			                    </div>
		                        <br>
		                        <hr class="colorgraph">
			                    <div class="row">
			                      	<div class="col-xs-12 col-sm-12 col-md-12">
			                          	{{Form::submit('Ingresar', array('class' => 'btn btn-lg btn-primary btn3d btn-block'))}}
			                       	</div>
			                    </div>
		                    </fieldset>
		                {{ Form::close() }}
                	</div>
              	</div>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>
@stop

@section('footer')
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<footer>
					<div class="well">FOOTER</div>
				</footer>
			</div>
		</div>
	</div>
@stop

@section('files-js')
  	{{ HTML::script('assets/js/registrousuario.js') }}
  	{{ HTML::script('assets/js/utilidades.js') }}
	{{ HTML::script('assets/js/lugares.js') }}
@stop