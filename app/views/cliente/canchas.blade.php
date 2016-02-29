@extends('plantilla')

@section('titulo')
	Reserva tu cancha y Vao a Pelotear!
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

						<div class="col-sm-2">
									
						</div>						
						{{ Form::open(array('url' => 'canchas', 'method' => 'POST')) }}
		                    <div class="col-xs-12 col-sm-8 col-md-8">
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
		                    <div class="col-xs-12 col-sm-2 col-md-2" align="center">
		                      	<br>
		                      	{{Form::button('<span class="glyphicon glyphicon-search"></span> Buscar!', array('type' => 'submit', 'class' => 'btn btn-success btn-lg btn3d', 'id' => 'btnBuscarCancha1'))}}
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
									<li><a href="#"><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""></a></li>
									<li><a href="#"><img src="{{ asset('assets/img/trophy.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""><img src="{{ asset('assets/img/trophy-empty.png') }}" alt=""></a></li>
								</ul>
							</div>
							<br>
							<br>
							<div class="form-group">
		                        {{ Form::select('cboProvincia', array('Provincia' => 'Provincia', 'Trujillo' => 'Trujillo'), 'Trujillo', array('class' => 'form-control', 'id' => 'cboProvincia', 'style' => 'width:170px;')) }}
		                    </div>
		                    <div class="form-group">
		                        {{ Form::select('cboDistrito', array('Distrito' => 'Distrito', 'Trujillo' => 'Trujillo', 'Huanchaco' => 'Huanchaco'), 'Trujillo', array('class' => 'form-control', 'id' => 'cboDistrito', 'style' => 'width:170px;')) }}
		                    </div>
						</div>
						<br>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9">

				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">
						    <div class="row">
								<div class="col-md-9 col-sm-8 col-xs-12" align="left">
									<h2><strong>Aventura Soccer Trujillo</strong> <small>Trujillo, Trujillo</small></h2>
								</div>
								<div class="col-md-3 col-sm-4 col-xs-12" align="right">
									<h3>
										<img src="{{ asset('assets/img/trophy.png') }}" alt="">
										<img src="{{ asset('assets/img/trophy.png') }}" alt="">
										<img src="{{ asset('assets/img/trophy.png') }}" alt="">
										<img src="{{ asset('assets/img/trophy.png') }}" alt="">
										<img src="{{ asset('assets/img/trophy.png') }}" alt="">
									</h3>
								</div>
							</div>
						</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-12">
										<a href="" class="thumbnail">
											<img class="img-rounded img-responsive" src="{{ asset('assets/img/8.png') }}" alt="">
										</a>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 hidden-xs">
										<a href="" class="thumbnail">
											<img class="img-rounded" src="{{ asset('assets/img/8.png') }}" alt="">
										</a>
									</div>
									<div class="col-sm-6 hidden-xs">
										<a href="" class="thumbnail">
											<img class="img-rounded" src="{{ asset('assets/img/8.png') }}" alt="">
										</a>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								{{ Form::open(array('role' => 'form')) }}
									<div class="form-group">
										<label>Dirección: </label>
    									<p class="form-control-static">Interseccion Prolongacion Av. Juan Pablo II y Prolongación Av. huamán S/N - Altura Cuadra 12 Av.Larco (Grifo Primax)</p>
									</div>
									<div class="form-group">
										<label>Telefono: </label>
    									<p class="form-control-static">044-675168 / 829*5133 / 044-948950772</p>
									</div>
									<div class="form-group">
										<label>Servicios: </label>
    									<p class="form-control-static"><a>Ver Servicios</a></p>
									</div>
									<div align="center" class="col-sm-6">
										<div class="form-group">
											<label>Cancha: </label>
											<p class="form-control-static">
		    									<select name="" id="" class="form-control"> 
													<option value="">Cancha 1</option>
													<option value="">Cancha 2</option>
													<option value="">Cancha 3</option>
												</select>
											</p>
										</div>
									</div>
									<div align="center" class="col-sm-6">
										<div class="form-group">
											<label>Hoy: </label>
											<p class="form-control-static">
	    										<select name="" id="" class="form-control"> 
													<option value="">18:00 - 19:00</option>
													<option value="">19:05 - 20:05</option>
													<option value="">20:10 - 21:10</option>
												</select>
											</p>
										</div>
									</div>
									<hr>
									<div align="center">
										<button type="button" class="btn btn-success btn3d"><span class="glyphicon glyphicon-ok"></span> Reservar</button>  <button type="button" class="btn btn-info btn3d"><span class="glyphicon glyphicon-calendar"></span> Ver Calendario</button>
									</div>
								{{ Form::close() }}
							</div>
						</div>
					</div>
				</div>
					
				<div class="text-center">
					<ul class="pagination pagination-lg">
						<li><a href="#">&laquo;</a></li>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">&raquo;</a></li>
					</ul>
				</div>

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