<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Inicio: @yield('titulo')</title>

    <link rel="shortcut icon" href="{{asset('/image/ito.ico')}}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    

      <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">

   
    <link  rel="stylesheet" type="text/css" href="{{asset('/css/estilohome.css')}}">

  </head>

  <body style="background-image: url('image/logos_ito/itofondo.png'); background-size: cover; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF; background-attachment: fixed;">




    <div class="container-fluid" id="gob">
        <img src="image/gobmx.png" width="85" height="20" alt="gobmx">
    </div>

<div class="container">
  <div class="row">
    <div class="col-md-3" align="center">
       <img  src="{{asset('image/tec.png')}}" width="250" height="140" alt="logotecnm"/>
    </div>
    <div class="col-md-6" align="center">
      <h1 id="ito1"><strong>Instituto Tecnológico de Oaxaca</strong></h1>
      <h2 id="dpto1"><strong>Departamento de Ciencias de la Tierra</strong></h2>
      <h3 id="lab1"><strong>Laboratorio de Ingeniería Civil</strong></h3>
    </div>
    <div class="col-md-3" align="center">
       <img src="{{asset('image/logoITO.png')}}" width="150" height="140" alt="logoito"/>
    </div>
  </div>
</div>

<div class="container-fluid" id="tecnm">

   <div class="row">
    <div class="col-md-6" align="left">
 <img src="image/ito.png" width="30" height="30" />
   
        </div>
    
    <div class="col-md-6" align="right">
            <h4>ITO</h4>

    </div>
  </div>
  
   
  
</div>


    @yield('seccion')


    <div class="contain mt-5" align="center" >
      <section class="content-header">

       <img src="image/SEP-LOGO.png" width="250" height="90" alt="sep"/>


     </section>

   </div>

   <footer class="container-fluid text-center" style="background-color: #C7CCCC;" >
    <br>
    <p style="color: black; font-family: 'Arial';">Tecnológico Nacional de México / Instituto Tecnológico de Oaxaca</p>
    <p style="color: black;font-family: 'Arial';">Avenida Ing. Víctor Bravo Ahuja No. 125 Esquina Calzada Tecnológico, C.P. 68030</p>
    <p style="color: black;font-family: 'Arial';">Correo-e: tec_oax@itoaxaca.edu.mx - Tel: (951) 501 50 16</p>
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2020 Copyright:</div>
    <!-- Copyright -->
  </footer>




<!-- jQuery -->
<script src="{{asset('/requisitos/lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/requisitos/lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('/requisitos/lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('/requisitos/lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

  </body>
</html>