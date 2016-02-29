@extends('plantilla')

@section('titulo')
	Reserva tu cancha y Vao a Pelotear!
@stop

@section('files-css')
  {{ HTML::style('assets/css/panel-collapsible.css', array('media' => 'screen')) }}
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
			<div class="col-xs-12 col-sm-12 col-md-3">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h2 class="text-center"><strong>FILTRO</strong></h2>
					</div>
					<div class="panel-body">
						<div align="center">
							<div class="btn-group">
								{{ Form::button('<i class="fa fa-trophy"></i> Calificación <span class="caret"></span>', array('class' => 'btn btn-default dropdown-toggle', 'id' => 'btnBuscarCancha', 'data-toggle' => 'dropdown')) }}
								<ul class="dropdown-menu" role="menu">
									<li><a href="#"><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""></a></li>
									<li><a href="#"><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""></a></li>
									<li><a href="#"><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""></a></li>
								</ul>
							</div>
						</div>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9">

				@foreach ($listacanchas as $local)
				
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">
							    <div class="row">
									<div class="col-md-8 col-sm-7 col-xs-12" align="left">
										<h2><strong>{{ $local['local']->nombre }}</strong> <small>{{ $local['local']->provincia . ', ' . $local['local']->distrito }}</small></h2>
									</div>
									<div class="col-md-4 col-sm-5 col-xs-12" align="center">
										<h4>
											<label class="label label-primary">Calificación</label><br><br>
											<?php 
												$cant = $local['local']->calificacion;
												$cantEmpty = 5 - $cant;
											?>
											@for ($x = 0; $x < $cant ; $x++)
												<img src="{{ asset('assets/img/trophy.png') }}" alt="">
											@endfor
											@for ($x = 0; $x < $cantEmpty ; $x++)
												<img src="{{ asset('assets/img/trophy-empty.png') }}" alt="">
											@endfor
										</h4>
									</div>
								</div>
								<span class="pull-right clickable"><i class="glyphicon glyphicon-minus"></i></span>
							</h3>
							
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-12">
											<a href="" class="thumbnail" data-toggle="modal" data-target="#lightbox">
												<img class="img-rounded img-responsive" src="{{ asset('assets/img/8.png') }}" alt="">
											</a>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 hidden-xs">
											<a href="" class="thumbnail" data-toggle="modal" data-target="#lightbox">
												<img class="img-rounded" src="{{ asset('assets/img/8.png') }}" alt="">
											</a>
										</div>
										<div class="col-sm-6 hidden-xs">
											<a href="" class="thumbnail" data-toggle="modal" data-target="#lightbox">
												<img class="img-rounded" src="{{ asset('assets/img/8.png') }}" alt="">
											</a>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									{{ Form::open(array('role' => 'form')) }}
										<div class="form-group">
											<label>Dirección: </label>
	    									<p class="form-control-static">{{ $local['local']->direccion }}</p>
										</div>
										<div class="form-group">
											<label>Telefono: </label>
	    									<p class="form-control-static">{{ $local['local']->telefono }}</p>
										</div>
										<div class="form-group">
											<label>Servicios: </label>
	    									<p class="form-control-static"><a>Ver Servicios</a></p>
										</div>
										<div align="center" class="col-sm-12">
	    									  <button type="button" class="btn btn-info btn3d" id="btnVerCalendario" onclick="verCalendario({{ $local['local']->idlocal }})"><span class="glyphicon glyphicon-calendar"></span> Ver Calendario</button>
										</div>
										<br><br><br>
										<div align="center" class="col-sm-12">
											<table class="table table-bordered">
			    								<tr>
			    									<td colspan="3" align="center">
			    										Dia: {{ $fecha }} - Hora: {{ $hora }}
			    									</td>
			    								</tr>
			    								<tr>
			    									<td align="center">Cancha</td>
			    									<td align="center">Precio</td>
			    									<td></td>
			    								</tr>
			    								@foreach ($local['canchas'] as $cancha)
				    								<tr>
				    									<td align="center">{{ $cancha->descripcion }}</td>
				    									<td align="center">S/. {{ $cancha->precio }}</td>
				    									<td align="center">
				    										@if (Auth::check())
				    											{{Form::button('<span class="glyphicon glyphicon-ok"></span> Reservar', array('class' => 'btn btn-success btn3d', 'id' => 'btnReservar', 'onclick' => 'realizarAlquiler()'))}}
															@else
																{{Form::button('<span class="glyphicon glyphicon-ok"></span> Reservar', array('class' => 'btn btn-success btn3d', 'id' => 'btnReservar', 'onclick' => 'necesitaLogueo()'))}}
															@endif
				    									</td>
				    								</tr>
				    							@endforeach
			    							</table>
										</div>
									{{ Form::close() }}
								</div>
							</div>
						</div>
					</div>
				@endforeach

			</div>
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
	{{ HTML::script('assets/js/alquiler.js') }}
	{{ HTML::script('assets/js/panel-collapsible.js') }}
	{{ HTML::script('assets/js/utilidades.js') }}
	{{ HTML::script('assets/js/lugares.js') }}
@stop