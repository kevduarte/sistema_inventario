@extends('layouts.plantilla_personal')
@section('title')
: mis grupos practicas
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Prácticas programadas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">personal</a></li>
              <li class="breadcrumb-item active">grupos</li>
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
        <div class="table-responsive">

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family:Initial;">Grupos registrados para el uso del laboratorio durante el semestre:{{$name}}</h2>
   <thead class="thead-dark">
    <tr>
     <!-- el codigo lo creara y sera unico-->
      <th style="width: auto;;">GRUPO</th>
      <th scope="col">MATERIA</th>
      <th scope="col">CUPO</th>
      <th scope="col">CURSANDO</th>
      <th style=" font-weight:900; " >LUGARES DISPONIBLES</th>
          
            
       <th scope="col">HORARIO</th>
       <th scope="col">DÍAS</th>
       

     
    </tr>
  </thead>
   <tbody>
       @foreach ($dato as $datos)
       <tr >
              
             <th>{{$datos->grupo}}</th>
              <td>{{$datos->materia}}</td>
                <td>{{$datos->cupo}}</td>

                <td><?php $inscritos= ($datos->cupo)-($datos->control_cupo); echo $inscritos;?></td>
                <td>{{$datos->control_cupo}}</td>
                     
                        

                      <td><?php if(empty($datos->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_inicio));}?>-<?php if(empty($datos->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($datos->hora_fin));}?> hrs</td>

                       <td><?php if($datos->dia_uno==1){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_uno);}?> 
                       <?php if($datos->dia_dos==2){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_dos);}?>  
                       <?php if($datos->dia_tres==3){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_tres);}?>  
                       <?php if($datos->dia_cuatro==4){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cuatro);}?>  
                      <?php if($datos->dia_cinco==5){ $vacio=null; echo $vacio;} else{ echo ($datos->dia_cinco);}?> </td>
                     

                      
                     
                        

     
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

</div>



  @endsection
