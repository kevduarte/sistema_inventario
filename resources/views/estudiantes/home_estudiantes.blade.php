@extends('layouts.plantilla_estudiante')
@section('title')
: Inicio estudiantes
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Bienvenido </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
              <li class="breadcrumb-item active">Inicio</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif

<div class="container">


   <div class="table-responsive">

 
  <table class="table table-bordered" id="font2">
   <h2 style= "font-family: 'Initial';">Grupos cursando durante el semestre :{{$sem}}</h2>
   <thead>
    <tr>
      <th scope="col">GRUPO</th>
      <th scope="col">DOCENTE</th>
            <th scope="col">MATERIA</th>


      <th scope="col">HORARIO</th>
      
      <th scope="col">ESTADO</th>

     
    </tr>
  </thead>
  <tbody>
    @foreach($dato as $datos)

    <tr>

      <th>{{$datos->grupo}}</th>
      <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>
            <td>{{$datos->materia}}</td>



      <td><?php if(empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{echo date("H:i a", strtotime($datos->hora_inicio)); echo " a "; echo date("H:i a", strtotime($datos->hora_fin));} ?>
    </td>

    <td>{{$datos->estado}}</td>
   


  </tr>
  @endforeach
</tbody>
</table>
</div>

@if (count($dato))
{{ $dato->links() }}
@endif

@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO ESTAS INSCRITO ACTUALMENTE A UN GRUPO</h2>  

 @endif   
  
 
</div>




  @endsection

 