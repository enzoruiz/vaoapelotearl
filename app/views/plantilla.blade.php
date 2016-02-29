<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> @yield('titulo') </title>
    
    {{ HTML::style('assets/css/bootstrap.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/arreglo-typeahead.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/botones3d.css', array('media' => 'screen')) }}
    {{ HTML::style('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/font-awesome/css/font-awesome.min.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/form-ingresar.css', array('media' => 'screen')) }}
    {{ HTML::style('assets/css/lightbox.css', array('media' => 'screen')) }}

    @yield('files-css')

  </head>

  <body>
    
  <div class="container">
    {{-- Lightbox --}}
    <div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <div class="modal-content">
          <div class="modal-body">
            <img src="" alt="" />
          </div>
        </div>
      </div>
    </div> {{-- /.Lightbox --}}
    {{-- Modal --}}
    <div class="modal fade" id="modal-ingreso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Entra y Reserva tu cancha</h4>
          </div>
          <div class="modal-body">

            <div class="main">

              <div class="row">
                {{ Form::open(array('url' => 'login', 'method' => 'POST', 'role' => 'form')) }}
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <form role="form">
                      <fieldset>
                        <h2 class="text-center"><strong>Registrate ahora y te regalamos 1000 puntos de bienvenida!</strong></h2>
                        <div class="row">
                          <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="{{ URL::to('login/fb') }}" class="btn btn-lg btn-primary btn-block btn3d">Facebook</a>
                          </div>
                          <div class="col-xs-6 col-sm-6 col-md-6">
                            <a href="#" class="btn btn-lg btn-info btn-block btn3d">Google</a>
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
                    </form>
                  </div>
                {{ Form::close() }}
              </div>
                  
            </div>

          </div>
        </div>{{-- /.modal-content --}}
      </div>{{-- /.modal-dialog --}}
    </div>{{-- /.modal --}}
  </div>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <ul class="nav navbar-nav hidden-xs">
          <li><a class="navbar-brand" href="{{ URL::to('/') }}">Vao a Pelotear!</a></li>
        @yield('navbar')
      </div>
    </nav>
  
    @yield('cuerpo')

    @yield('footer')
    
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js') }}
    {{ HTML::script('http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js') }}
    {{ HTML::script('assets/js/bootstrap.js') }}
    {{ HTML::script('assets/js/typeahead.js') }}
    {{ HTML::script('http://code.jquery.com/ui/1.10.3/jquery-ui.js') }}
    {{ HTML::script('assets/js/jquery.ui.datepicker-es.js') }}
    {{ HTML::script('assets/js/lightbox.js') }}
    <script type="text/javascript">
      $(document).ready(function(){
        $('#dpcalendario').datepicker({
          defaultDateType : new Date(),
          dateFormat: "dd/mm/yy",
          minDate: new Date()
        });
        $('#dpcalendario').datepicker('setDate', new Date());
        $('#dpcalendario2').datepicker({
          defaultDateType : new Date(),
          dateFormat: "dd/mm/yy",
          minDate: new Date()
        });
        $('#dpcalendario2').datepicker('setDate', new Date());
        $('#txtBusquedaCancha').typeahead({
          name: 'canchas',
          prefetch: '{{ URL::to("search-cancha") }}'
        });
      });
      $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("active");
      });
    </script>
    @yield('files-js')

  </body>

</html>