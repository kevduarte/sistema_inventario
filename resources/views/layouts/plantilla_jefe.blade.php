<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Laboratorio de ingenieria civil @yield('title')</title>
  <link rel="shortcut icon" href="{{asset('image/ito.ico')}}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('requisitos/lte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('requisitos/lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('requisitos/lte/dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet"  href="{{asset('css/estiloadmin.css')}}">

</head>

<!-- fin del head del admin-->

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #AFAFAF;border-radius: 0px 0px 0px 0px; -moz-border-radius: 0px 0px 0px 0px; -moz-box-shadow: 10px 10px 5px -4px rgba(61,61,61,1); -webkit-border-radius: 0px 0px 0px 0px; -webkit-box-shadow: 10px 10px 5px -4px rgba(61,61,61,1); border: 0px solid #000000;">
      <!-- Left navbar links -->

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

       <span class="navbar-text" style="font-family:' Tahoma ';">DPTO. DE CIENCIAS DE LA TIERRA.</span>

      <ul class="navbar-nav ml-auto">

     
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">mensajes</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i>
            
          </a>

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">laboratorio</a>
        </div>
      </li>



              <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Cuenta </span></a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('cuenta_admin')}}" >
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-black-400"></i>
                    Configuración de cuenta
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-400"></i>
                    Cerrar Sesión
                  </a>
                </div>
              </li>

        

    </ul>

      
     


  </nav>
  <!-- /.navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 " style="background-color: #001539;">
    <!-- Brand Logo -->
    
    <a href="#" class="brand-link">
      <img class="img-responsive center-block" src="{{asset('image/ito.ico')}}" width="47" height="47" alt="">
      <span class="brand-text font-weight-dark" style="font-size: 1.0em; font-family: 'Century Gothic'; font-weight: 900;" >&nbsp;LABORATORIO</span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('image/topo.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
          <div class="info">
         <a href="{{route ('jefe')}}" class="d-block" id="didacinfo">
          <span style="font-family:Lucida Sans Unicode;">
          <?php $usuario_actual=Auth::user()->id_user;
          $id=$usuario_actual;

          $users = DB::table('personas')
          ->select('personas.nombre','personas.apellido_paterno')
          ->join('users', 'personas.id_persona', '=', 'users.id_persona')
          ->where('users.id_user',$id)
          ->take(1)
          ->first();  

          $rol= DB:: table('users')
          ->select('users.id_personal')
          ->where('users.id_user',$id)
           ->take(1)
          ->first(); 
          $rol=$rol->id_personal;

          $cargo=DB::table('personal')
          ->select('personal.cargo')
          ->where('personal.id_personal',$rol)
          ->take(1)
          ->first(); 
          $cargo=$cargo->cargo;

          echo $users->nombre." ".$users->apellido_paterno."";
        
          ?>
      </span>
      <br>
      <div align="center">
      <span style="font-size:small; font-family:Lucida Sans Unicode;">
         <i class="fa fa-circle text-success fa-xs"></i> <?php
          echo $cargo;
          ?>
       
      </span>
      </div>
    </a>
        </div>
      </div>




      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <!-- Agregue íconos a los enlaces utilizando la clase .nav-icon
           con font-awesome o cualquier otra biblioteca de fuentes de iconos  -->
           <li class="nav-header">
            <i class="fa fa-bars"></i>&nbsp;MENU</li>

             <li class="nav-item has-treeview">

            <a href="#" class="nav-link">
              <i class="fa fa-edit"></i>
              <p style="font-family: 'Arial, Helvetica, sans-serif';">
                Gestión de Materiales
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href={{ route('registro_material_jefe')}} class="nav-link">
                  <i class="fa fa-plus-circle nav-icon"></i>
                  <p>Registrar</p>
                </a>
              </li>
               <li class="nav-item">
                <a href={{ route('materiales_activos_jefe')}} class="nav-link">
                  <i class="fa fa-check nav-icon"></i>
                  <p>Materiales Activos</p>
                </a>
              </li>
               
               <li class="nav-item">
                <a href={{ route('material_inactivo_jefe')}} class="nav-link">
                  <i class="fa fa-ban nav-icon"></i>
                  <p>Materiales Inactivos</p>
                </a>
              </li>
            
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="fa fa-cog nav-icon"></i>
                  <p>Categorías 
                     <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                <a href={{ route('registro_tipo_jefe')}} class="nav-link">
                  <i class="fa fa-plus nav-icon"></i>
                  <p>Nueva</p>
                </a>
              </li>
                </ul>
              </li>
               <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->

            </ul>


          </li>
          <!-- Gestión de materiales -->


           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fa fa-file"></i>
              <p style="font-family: 'Arial, Helvetica, sans-serif';">
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa fa-barcode nav-icon"></i>
                  <p>Materiales</p>
                <i class="right fas fa-angle-left"></i>
                </a>
                 <ul class="nav nav-treeview">
                  <li class="nav-item">
                <a href={{ route('reporte_eliminados_jefe')}} class="nav-link">
                  <i class="fa fa-trash nav-icon"></i>
                  <p>Baja definitiva</p>
                </a>
              </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                <a href={{ route('reporte_temporal_jefe')}} class="nav-link">
                  <i class="fa fa-eraser nav-icon"></i>
                  <p>Baja temporal</p>
                </a>
              </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href={{ route('adeudos_material_jefe')}} class="nav-link">
                  <i class="fa fa-ban nav-icon"></i>
                  <p>Adeudos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prestamos</p>

                </a>
              </li>
 <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
            </ul>
          </li>


      


          
          

         






        </ul>

 <hr class="sidebar-divider" style=" background-color: #5B7194;"><!-- Heading -->
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-image: url('image/logos_ito/itofondo.png'); background-size: cover; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF;">


    <!-- Main content -->
    @yield('seccion')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Footer -->
  <footer class="main-footer" style="background-color: #CACACA; border-radius: 0px 0px 0px 0px; -moz-box-shadow: 10px 10px 17px 1px rgba(0,0,0,0.75); -webkit-box-shadow: 10px 10px 17px 1px rgba(0,0,0,0.75); box-shadow: 10px 10px 17px 1px rgba(0,0,0,0.75); border: 0px solid #000000;">
 <div class="float-right d-none d-sm-block">
      <b>Dpto. de ciencias de la tierra</b>
    </div>
    <strong>Copyright &copy; 2014-2019-<a>Instituto Tecnológico de Oaxaca</a>.</strong>


</footer>
<!-- End of Footer -->

 


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">

    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header modal-header-danger">
          <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar Sesión?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Presione "Finalizar Sesión" para confirmar.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="{{ route('logout_system') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Finalizar Sesión</a>

         <form id="logout-form" action="{{ route('logout_system') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

  

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('requisitos/lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('requisitos/lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('requisitos/lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('requisitos/lte/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('requisitos/lte/dist/js/demo.js')}}"></script>

<!--TABLA BUSCAR-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>



  <script src="{{asset('requisitos/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('requisitos/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('requisitos/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>






</body>
</html>

