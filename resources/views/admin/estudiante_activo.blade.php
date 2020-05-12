@extends('layouts.plantilla_admin')
@section('title')
: Estudiantes activos
@endsection

@section('seccion')
@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Estudiantes del laboratorio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
              <li class="breadcrumb-item active">Activos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


   <div class="container">


   @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Segoe UI';">-Relación de estudiantes-</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
            <th scope="col">N. CONTROL</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">SEMESTRE</th>
      <th scope="col">GRUPO</th>

      <th colspan="3">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
  
      <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td align="center"><a href="#">DESACTIVAR</a></td>
       <td align="center"><a href="#">ACTUALIZAR</a></td>
       <td align="center"><a href="#">VER HISTORIAL</a></td>
        
    </tr>

   
  </tbody>



  
</table>





</div>



  @endsection
