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
					<!-- Modal -->
					<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" id="myModalLabel">Terminos y Condiciones</h4>
								</div>
								<div class="modal-body">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal">Acepto</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
                  	<div class="well">
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
                  		{{ Form::open(array('url' => 'registro', 'method' => 'POST', 'role' => 'form')) }}
	                    	<h2>Registrate <small>Es gratis y siempre lo sera.</small></h2>
	                    	<hr class="colorgraph">
	                    	<div class="form-group">
	                      		{{ Form::text('nombrecompleto', '', array('id' => 'nombrecompleto', 'class' => 'form-control input-lg', 'placeholder' => 'Nombre Completo', 'tabindex' => '1', 'required')) }}
	                    	</div>
	                    	<div class="row">
	                      		<div class="col-xs-6 col-sm-6 col-md-6">
		                        	<div class="form-group">
		                          		{{ Form::text('dni', '', array('id' => 'dni', 'class' => 'form-control input-lg', 'placeholder' => 'Dni', 'tabindex' => '2', 'required', 'maxlength' => '8')) }}
		                        	</div>
	                      		</div>
		                      	<div class="col-xs-6 col-sm-6 col-md-6">
		                        	<div class="form-group">
		                          		{{ Form::text('celular', '', array('id' => 'celular', 'class' => 'form-control input-lg', 'placeholder' => 'Celular', 'tabindex' => '3', 'required')) }}
		                        	</div>
		                      	</div>
	                    	</div>
	                    	<div class="form-group">
	                      		{{ Form::email('email', '', array('id' => 'email', 'class' => 'form-control input-lg', 'placeholder' => 'Email', 'tabindex' => '4', 'required')) }}
	                    	</div>
	                    	<div class="form-group">
	                          	{{ Form::text('username', '', array('id' => 'username', 'class' => 'form-control input-lg', 'placeholder' => 'Username', 'tabindex' => '5', 'required')) }}
	                        </div>
	                    	<div class="row">
	                      		<div class="col-xs-6 col-sm-6 col-md-6">
	                        		<div class="form-group">
	                          			{{ Form::password('password', array('id' => 'password', 'class' => 'form-control input-lg', 'placeholder' => 'Password', 'tabindex' => '6', 'required')) }}
	                        		</div>
	                      		</div>
	                      		<div class="col-xs-6 col-sm-6 col-md-6">
	                        		<div class="form-group">
	                          			{{ Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control input-lg', 'placeholder' => 'Confirma Password', 'tabindex' => '7', 'required')) }}
	                        		</div>
	                      		</div>
	                    	</div>
	                    	<div class="row">
	                      		<div class="col-xs-4 col-sm-3 col-md-3">
	                        		<span class="button-checkbox">
		                          		<button type="button" class="btn" data-color="info" tabindex="9">Acepto</button>
		                                <input type="checkbox" name="t_and_c" id="t_and_c" class="hidden" value="0">
		                                {{ Form::hidden('terminos', '', array('id' => 'terminos')) }}
	                        		</span>
	                      		</div>
	                      		<div class="col-xs-8 col-sm-9 col-md-9">
	                         		By clicking <strong class="label label-primary">Registrar</strong>, you agree to the <a href="#" data-toggle="modal" data-target="#t_and_c_m">Terms and Conditions</a> set out by this site, including our Cookie Use.
	                      		</div>
	                    	</div>
	                    	<hr class="colorgraph">
	                    	<div class="row">
	                      		<div class="col-xs-12 col-md-12">
	                      			<input type="submit" value="Registrarme" class="btn btn3d btn-success btn-block btn-lg" tabindex="9">
	                      		</div>
	                    	</div>
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