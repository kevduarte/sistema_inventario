
@extends('layouts.plantilla_docente')
@section('title')
: inicio docente
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
              <li class="breadcrumb-item"><a href="#">Docente</a></li>
              <li class="breadcrumb-item active">Inicio</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

      <div class="container">

              <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3></h3>

                <p>Grupos</p>
              </div>
              <div class="icon">
                <i class="fa fa-barcode"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3></h3>

                <p>Solicitudes</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        
        </div>
        <!-- /.row -->

         <div class="col-md-12 ">
    <div class="login-or">
      <hr class="hr-or">
   </div>
 </div>

  </div>

<div class="container">


@if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family:Initial;">Grupos registrados durante el semestre: {{$detalle}}</h2>
   <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th style="width: auto;;">GRUPO</th>
      <th scope="col">MATERIA</th>
      <th scope="col">CUPO</th>

          
            
       <th scope="col">HORARIO</th>
       <th scope="col">DÍAS</th>
        <th scope="col">ÁREA</th>
              <th colspan="2">ACCIONES</th>

       

     
    </tr>
  </thead>
   <tbody>
       @foreach ($dato as $datos)
       <tr >
              
              <th>{{$datos->grupo}}</th>
              <td>{{$datos->materia}}</td>
                <td>{{$datos->cupo}}</td>

                     
                        

                      <td><?php if(empty($datos->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_inicio));}?>-<?php if(empty($datos->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_fin));}?> hrs</td>

                       <td><?php if($datos->dia_uno==1){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_uno);}?> 
                       <?php if($datos->dia_dos==2){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_dos);}?>  
                       <?php if($datos->dia_tres==3){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_tres);}?>  
                       <?php if($datos->dia_cuatro==4){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cuatro);}?>  
                      <?php if($datos->dia_cinco==5){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cinco);}?> </td>
                       <td>{{$datos->area}}</td>

             <td WIDTH="50"><a href="{{ route ('actualizar_grupo',$datos->id_grupo)}}"><button type="button" class="btn btn-success btn-sm">Actualizar</button></a></td>


                     
        
     
            </tr>
         @endforeach
     </tbody>


  
</table>
@if (count($dato))
  {{ $dato->links() }}
@endif

@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO TIENE GRUPOS REGISTRADOS</h2>  

 @endif   







</div>





  @endsection

 

 