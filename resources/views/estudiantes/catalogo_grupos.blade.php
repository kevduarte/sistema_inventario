@extends('layouts.plantilla_estudiante')
@section('title')
:catalogo grupos
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Grupos </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
              <li class="breadcrumb-item active">grupos</li>
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




 
  <table class="table table-bordered" id="font2">
   <h2 style= "font-family: 'Initial';">Grupos registrados durante el periodo: {{$sem}}</h2>
   <thead>
    <tr>
      <th scope="col">GRUPO</th>
      <th scope="col">MATERIA</th>

      <th scope="col">DOCENTE</th>
      <th scope="col">HORARIO</th>
      
      <th scope="col">CUPO</th>

      <th colspan="1" >ACCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach($dato as $datos)

    <?php
    $usuario_actual=auth()->user();
    $id=$usuario_actual->id_user;
    $usuario=DB::table('detalle_grupos')
    ->select('detalle_grupos.nom_grupo')
    ->where([['detalle_grupos.nom_grupo',$datos->id_grupo], ['detalle_grupos.num_control', $id]])
    ->first(1); ?>




    <tr>

      <td>{{$datos->grupo}}</td>
      <td>{{$datos->materia}}</td>

      <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>

     <td><?php if(empty($datos->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_inicio));}?>-<?php if(empty($datos->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_fin));}?> hrs</td>

    <td>{{$datos->control_cupo}}</td>
    <td><a href="inscripcion_grupo/{{ $datos->id_grupo}}"><?php if(empty($usuario)){echo "INSCRIBIRSE";}?></a></td>


  </tr>
  @endforeach
</tbody>
</table>

@if (count($dato))
{{ $dato->links() }}
@endif

@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY GRUPOS DISPONIBLES</h2>  

 @endif   

   


</div>





@endsection

