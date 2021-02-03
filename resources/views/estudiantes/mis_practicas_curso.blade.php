@extends('layouts.plantilla_estudiante')
@section('title')
:mis prácticas en curso
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Mis prácticas</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Prácticas</a></li>
          <li class="breadcrumb-item active">en curso</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('message') }}   
       </div>
    @endif

    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('mess') }}
    </div>
    @endif




<div class="container">



    <div class="table-responsive">

  <table class="table table-bordered" id="font2">
   <h2 style= "font-family: 'Initial';">Prácticas :{{$sem2}}</h2>
   <thead>
    <tr>
      <th scope="col">GRUPO</th>
      <th scope="col">FECHA</th>
            <th scope="col">HORARIO</th>
                        <th scope="col">ESTADO</th>
                                                <th scope="col">ÁREA</th>




     
    </tr>
  </thead>
  <tbody>
    @foreach($dato as $datos)

    <tr>

      <th>{{$datos->grupo}}</th>
      <td>{{$datos->fecha_prestamo}}</td>
      <td><?php if(empty($datos->hora_inicio_sol)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_inicio_sol));}?>-<?php if(empty($datos->hora_fin_sol)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_fin_sol));}?> hrs</td>
      <td>{{$datos->estado_vale}}</td>
            <td>{{$datos->area}}</td>




    


  </tr>
  @endforeach
</tbody>
</table>
</div>

@if (count($dato))
{{ $dato->links() }}
@endif

@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY PRÁCTICAS PENDIENTES</h2>  

 @endif   
  
 
</div>



  @endsection
