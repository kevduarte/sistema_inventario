@extends('layouts.plantilla_jefe')
@section('title')
:mis solicitudes
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Adeudos de material</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Prestamos</a></li>
              <li class="breadcrumb-item active">adeudos</li>
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

  @if (Session::has('mes'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('mes') }}</strong>
  </div>
  @endif

  <div class="container" id="font1">
 
</br>
  <table class="table table-bordered" id="font5">
   <h2>Solicitudes que presentan adeudos</h2>
   <thead class="thead-dark">
    <tr>

      <th scope="col">GRUPO</th>
      <th scope="col">DOCENTE</th>
      <th scope="col">DÍA DE PRÁCTICA</th>
      <th scope="col">HORARIO</th>
      <th scope="col">FOLIO SOLICITUD</th>
      <th scope="col">FECHA DE APROBACIÓN</th>
            <th scope="col">SEMESTRE</th>



      <th colspan="2">ACCIONES</th>




    </tr>
  </thead>

  <tbody>
    @foreach($solicitudes as $sol)
    <tr>
     <th>{{ $sol->grupo}}</th>
     <td>{{ $sol->nombre}} {{$sol->apellido_paterno}} {{$sol->apellido_materno}}</td>

     <td><?php $date=date_create($sol->fecha_prestamo);
     echo date_format($date,"F j, Y");  ?></td>

     <td><?php if(empty($sol->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($sol->hora_inicio));}?>-<?php if(empty($sol->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($sol->hora_fin));}?> hrs</td>
     <td>{{ $sol->id_solicitud}}</td>
     <td><?php $date=date_create($sol->fecha_solicitud);
     echo date_format($date,"F j, Y"); ?></td>
      <td>{{ $sol->nombre_semestre}}</td>
     

     <td ><a href="/adeudo_solicitud_jefe/{{$sol->id_solicitud}}"><button type="button" class="btn btn-primary btn-sm">Ver <i class="fa fa-eye" aria-hidden="true"></i></button></a></td>
     
     
     

      
    </tr>

    @endforeach

  </tbody>
</table>
{{ $solicitudes->links() }}

</br>


@if($solicitudes->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:#FFE739;">Aún no ha realizado solicitudes</h2>  

 @endif 

 


</div>



@endsection
