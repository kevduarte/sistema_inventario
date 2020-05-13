<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="shortcut icon" href="{{asset('/image/ito.ico')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   
    <link  rel="stylesheet" href="{{asset('/css/estilohome.css')}}" type="text/css">

     <title>Inicio: @yield('titulo')</title>
  </head>




  <body style="background-image: url('image/logos_ito/itofondo.png'); background-size: cover; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF  ;">


    <nav class="navbar navbar-light bg-custom">
      <a class="navbar-brand">
        <img src="image/gobmx.png" width="85" height="20" ></a>
      </nav>

<div class="container">
  <div class="row justify-content-md-center">
    <div class="col">
       <img  src="{{asset('image/tec.png')}}" width="250" height="140" alt=""/>
    </div>
    <div class="col-md-auto">
      <h1 style="color: rgb(27, 57, 106);"><strong>Instituto Tecnológico de Oaxaca</strong></h1>
      <h2 style="color: rgb(27, 57, 106);"><strong>Departamento de Ciencias de la Tierra</strong></h2>
      <h3 style="color: rgb(27, 57, 106);"><strong>Laboratorio de Ingeniería Civil</strong></h3>
    </div>
    <div class="col">
       <img src="{{asset('image/logoITO.png')}}" width="150" height="140" alt=""/>
    </div>
  </div>
</div>

<nav class="navbar navbar-dark bg-custom2">
  
  <a class="navbar-brand" href="#">
     <img src="image/ito.png" width="30" height="30" class="d-inline-block align-top" alt="">
    TecNM-ITO
  </a>
</nav>


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