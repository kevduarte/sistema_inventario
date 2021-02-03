@extends('layouts.plantilla_docente')
@section('title')
:solicitar material
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Solicitar material</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Préstamos</a></li>
          <li class="breadcrumb-item active">solicitar material</li>
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

  @if (Session::has('mes'))
  <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ Session::get('mes') }}</strong>
  </div>
  @endif

  <div class="table-responsive">

    <table class="table table-bordered" id="font2">
      <h2  style= "font-family: 'initial';">Lista de grupos para realizar solicitud de material</h2>

      <thead class="thead-dark">
        <tr>
          <!-- el codigo lo creara y sera unico-->
          <th style="width: auto;;">GRUPO</th>
          <th scope="col">MATERIA</th>
          <th scope="col">ÁREA DE PRÁCTICA</th>



          

          <th scope="col">HORARIO DE PRÁCTICAS</th>
          <th scope="col">DÍAS DE PRÁCTICAS</th>



          <th colspan="2">ACCIONES</th>
        </tr>
      </thead>
      <tbody>
       @foreach ($dato as $datos)
       <tr >

        <th>{{$datos->grupo}}</th>
        <td>{{$datos->materia}}</td>
        <td>{{$datos->area}}</td>




        <td><?php if(empty($datos->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i ", strtotime($datos->hora_inicio));}?>-<?php if(empty($datos->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_fin));}?> hrs</td>

        <td><?php if($datos->dia_uno==1){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_uno);}?> 
        <?php if($datos->dia_dos==2){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_dos);}?>  
        <?php if($datos->dia_tres==3){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_tres);}?>  
        <?php if($datos->dia_cuatro==4){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cuatro);}?>  
        <?php if($datos->dia_cinco==5){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cinco);}?> </td>



        <td><a href="{{ route ('solicitud_grupo',$datos->id_grupo)}}"><button type="button" class="btn btn-success btn-sm">Realizar solicitud <i class="fa fa-file"></i></button></a></td>

      </tr>
      @endforeach
    </tbody>



  </table>
  @if (count($dato))
  {{ $dato->links() }}
  @endif

  @if($dato->count()==0)
  <h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">AÚN NO TIENE GRUPOS REGISTRADOS</h2>  

  @endif   

</div>



</div>



@endsection
