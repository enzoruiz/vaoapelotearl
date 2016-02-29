@extends('plantilla')

@section('titulo')
  Reserva tu cancha y Vao a Pelotear!
@stop

@section('files-css')
  {{-- Add custom CSS here --}}
  {{ HTML::style('assets/css/stylish-portfolio.css', array('media' => 'screen')) }}
  {{ HTML::style('assets/css/registrousuario.css', array('media' => 'screen')) }}
@stop


@section('navbar')
    <li><a href="#">Premios</a></li>
  </ul>
  @if( Auth::check() )
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
  {{-- Full Page Image Header Area --}}
    <div id="top" class="header">
      <div class="vert-text">
        
        <div class="container">
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div align="center">
                  <h1 class="hidden-xs">Reserva tu cancha y Vao a pelotear!</h1>
                  <h2 class="visible-xs">Reserva tu cancha y Vao a pelotear!</h2>
                </div>
                <br>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="hidden-xs">
                  {{Form::button('<span class="glyphicon glyphicon-ok"></span> Reservar en mi Cancha Preferida', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn3d', 'id' => 'btnBuscarCancha', 'onclick' => 'mostrar1()'))}}
                  {{Form::button('<span class="glyphicon glyphicon-map-marker"></span> Encontrar Canchas Disponibles', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn3d', 'id' => 'btnBuscarCancha', 'onclick' => 'mostrar2()'))}}
                </div>
                <div class="visible-xs">
                  {{Form::button('<span class="glyphicon glyphicon-ok"></span> Reservar en mi Cancha Preferida', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn3d', 'id' => 'btnBuscarCancha', 'onclick' => 'mostrar1()'))}}
                  <br>
                  <br>
                  {{Form::button('<span class="glyphicon glyphicon-map-marker"></span> Encontrar Canchas Disponibles', array('type' => 'submit', 'class' => 'btn btn-default btn-lg btn3d', 'id' => 'btnBuscarCancha', 'onclick' => 'mostrar2()'))}}
                </div>
                <br>
                <br>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12">
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
              <div class="col-xs-12 col-sm-10 col-md-10">
                @if (Session::get('mensaje'))
                  <div class="alert alert-success fade in">
                    <button class="close" data-dismiss="alert" href="#" aria-hidden="true">x</button>
                    {{ Session::get('mensaje') }}
                  </div>
                @endif
                @if ($errors->any())
                  <div class="alert alert-danger fade in">
                    <button class="close" data-dismiss="alert" href="#" aria-hidden="true">x</button>
                      @foreach ($errors->all() as $error)
                        {{ $error }}
                      @endforeach
                  </div>
                @endif
              </div>
          </div>
        </div>

      </div>
    </div>
    {{-- /Full Page Image Header Area --}}
  
    {{-- Intro --}}
    <div id="about" class="intro">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            <h2>Subtle Sidebar is the Perfect Template for your Next Portfolio Website Project!</h2>
            <p class="lead">This template really has it all. It's up to you to customize it to your liking! It features some fresh photography courtesy of <a target="_blank" href="http://join.deathtothestockphoto.com/">Death to the Stock Photo</a>.</p>
          </div>
        </div>
      </div>
    </div>
    {{-- /Intro --}}
  
    {{-- Services --}}
    <div id="services" class="services">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4 text-center">
            <h2>Our Services</h2>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 col-md-offset-2 text-center">
            <div class="service-item">
              <i class="service-icon fa fa-rocket"></i>
              <h4>Spacecraft Repair</h4>
              <p>Did your navigation system shut down in the middle of that asteroid field? We can repair any dings and scrapes to your spacecraft!</p>
            </div>
          </div>
          <div class="col-md-2 text-center">
            <div class="service-item">
              <i class="service-icon fa fa-magnet"></i>
              <h4>Problem Solving</h4>
              <p>Need to know how magnets work? Our problem solving solutions team can help you identify problems and conduct exploratory research.</p>
            </div>
          </div>
          <div class="col-md-2 text-center">
            <div class="service-item">
              <i class="service-icon fa fa-shield"></i>
              <h4>Blacksmithing</h4>
              <p>Planning a time travel trip to the middle ages? Preserve the space time continuum by blending in with period accurate armor and weapons.</p>
            </div>
          </div>
          <div class="col-md-2 text-center">
            <div class="service-item">
              <i class="service-icon fa fa-pencil"></i>
              <h4>Pencil Sharpening</h4>
              <p>We've been voted the best pencil sharpening service for 10 consecutive years. If you have a pencil that feels dull, we'll get it sharp!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- /Services --}}

    <!-- Callout -->
    <div class="callout">
      <div class="vert-text">
        <h1>Vao a pelotear!</h1>
      </div>
    </div>
    {{-- /Callout --}}

    {{-- Portfolio --}}
    <div id="portfolio" class="portfolio">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4 text-center">
            <h2>Our Work</h2>
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-md-offset-2 text-center">
            <div class="portfolio-item">
              <a href="#"><img class="img-portfolio img-responsive" src="img/portfolio-1.jpg"></a>
              <h4>Cityscape</h4>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="portfolio-item">
              <a href="#"><img class="img-portfolio img-responsive" src="img/portfolio-2.jpg"></a>
              <h4>Is That On Fire?</h4>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-md-offset-2 text-center">
            <div class="portfolio-item">
              <a href="#"><img class="img-portfolio img-responsive" src="img/portfolio-3.jpg"></a>
              <h4>Stop Sign</h4>
            </div>
          </div>
          <div class="col-md-4 text-center">
            <div class="portfolio-item">
              <a href="#"><img class="img-portfolio img-responsive" src="img/portfolio-4.jpg"></a>
              <h4>Narrow Focus</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- /Portfolio --}}

    {{-- Call to Action --}}
    <div class="call-to-action">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            <h3>The buttons below are impossible to resist.</h3>
            <a href="#" class="btn btn-lg btn-default">Click Me!</a>
            <a href="#" class="btn btn-lg btn-primary">Look at Me!</a>
          </div>
        </div>
      </div>
    </div>
    {{-- /Call to Action --}}

    {{-- Map --}}
    <div id="contact" class="map">
      <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;aq=0&amp;oq=twitter&amp;sll=28.659344,-81.187888&amp;sspn=0.128789,0.264187&amp;ie=UTF8&amp;hq=Twitter,+Inc.,+Market+Street,+San+Francisco,+CA&amp;t=m&amp;z=15&amp;iwloc=A"></a></small></iframe>
    </div>
    {{-- /Map --}}
@stop

@section('footer')    
  {{-- Footer --}}
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-3 text-center">
            <ul class="list-inline">
              <li><i class="fa fa-facebook fa-3x"></i></li>
              <li><i class="fa fa-twitter fa-3x"></i></li>
              <li><i class="fa fa-dribbble fa-3x"></i></li>
            </ul>
            <div class="top-scroll">
              <a href="#top"><i class="fa fa-circle-arrow-up scroll fa-4x"></i></a>
            </div>
            <hr>
            <p>Copyright &copy; Company 2013</p>
          </div>
        </div>
      </div>
    </footer>
  {{-- /Footer --}}
@stop

@section('files-js')
  {{-- JavaScript --}}
  {{ HTML::script('assets/js/utilidades.js') }}
  {{ HTML::script('assets/js/lugares.js') }}

  {{-- Custom JavaScript for the Side Menu and Smooth Scrolling --}}
  <script>
      $("#menu-close").click(function(e) {
          e.preventDefault();
          $("#sidebar-wrapper").toggleClass("active");
      });
  </script>
  <script>
      $("#menu-toggle").click(function(e) {
          e.preventDefault();
          $("#sidebar-wrapper").toggleClass("active");
      });
  </script>
  <script>
    $(function() {
      $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
          || location.hostname == this.hostname) {

          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    });
  </script>
@stop