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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
   
    <link  rel="stylesheet" href="{{asset('/css/estilohome.css')}}">

  </head>

  <body style="background-image: url('image/logos_ito/itofondo.png'); background-size: cover; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF  ;">


    <div class="container-fluid" id="gob">
        <img src="image/gobmx.png" width="85" height="20" >
    </div>

<div class="container">
  <div class="row">
    <div class="col-md-3" align="center">
       <img  src="{{asset('image/tec.png')}}" width="250" height="140" alt=""/>
    </div>
    <div class="col-md-6" align="center">
      <h1 id="ito1"><strong>Instituto Tecnológico de Oaxaca</strong></h1>
      <h2 id="dpto1"><strong>Departamento de Ciencias de la Tierra</strong></h2>
      <h3 id="lab1"><strong>Laboratorio de Ingeniería Civil</strong></h3>
    </div>
    <div class="col-md-3" align="center">
       <img src="{{asset('image/logoITO.png')}}" width="150" height="140" alt=""/>
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

       <img src="image/SEP-LOGO.png" width="250" height="90" alt=""/>


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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


  </body>
</html>