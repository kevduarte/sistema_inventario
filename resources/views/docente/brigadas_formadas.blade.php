@extends('layouts.plantilla_docente')
@section('title')
:brigadas formadas
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Brigadas formadas del grupo: {{$detalle}} </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route ('brigadas_grupos')}}">Docente</a></li>
                <li class="breadcrumb-item active"><a href="{{ route ('brigadas_grupos')}}">grupos</a></li>
                 <li class="breadcrumb-item active">brigadas</li>
                 <li class="breadcrumb-item active">ver</li>
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

   <div class="container" id="font2">



      </br>

       <div class="container" align="right">
   <i class="fa fa-users" aria-hidden="true"></i><a style=" font-weight:900;color:#0D006F;" 
   href="/registro_brigada/{{$deta}}/{{$doce}}">Agregar brigada</a>

   
</div>


 <div class="container" align="left">
 <h6 style=" font-weight:900;"> <i class="fa fa-info-circle" aria-hidden="true">&nbsp;</i>Información del grupo:</h6>
  </div>


<div class="container" >



   
   <div class="form-row">
      
        <div class="form-group col-md-2">
         Cupo
          <input type="text"  value="{{$info->cupo}}" disabled  class="form-control "
          id="id_material" name="id_material">
    
       </div>

       <div class="form-group col-md-2">
          Lugares disponibles
          <input type="text"  value="{{$info->control_cupo}}" disabled  class="form-control "
          id="id_material" name="id_material">
    
       </div>

       <div class="form-group col-md-2">
         Numero de brigadas
          <input type="text"  value="{{$num}}" disabled  class="form-control "
          id="id_material" name="id_material">
    
       </div>
         <div class="form-group col-md-2">
       Estudiantes cursando
          <input type="text"  value="{{$det}}" disabled  class="form-control "
          id="id_material" name="id_material">
    
       </div>

     

     
        </div>
   

    </div>

   


     

  </br>
  <table class="table table-bordered" id="font3">
  
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th style="width: auto;;">NOMBRE BRIGADA</th>
      <th scope="col">CUPO</th>
      <th scope="col">MIEMBROS</th>
 
      <th style=" font-weight:900; " >LUGARES DISPONIBLES</th>
          

       

     
      <th colspan="4">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
       @foreach ($dato as $datos)
       <tr >
              
              <td>{{$datos->nombre_brigada}}</td>
        
         
                <td>{{$datos->cupo_brigada}}</td>

                    <td><?php $inscritos= ($datos->cupo_brigada)-($datos->control_brigada); echo $inscritos;?></td>

                     <td>{{$datos->control_brigada}}</td>
                     
                        


                      


             <td><a href="/llenar_brigadas/{{ $datos->id_brigada}}"><?php $dat=$datos->id_brigada; $ver = DB::table('detalle_brigadas') ->select('detalle_brigadas.id_brigada') ->where('detalle_brigadas.id_brigada', '=',$dat)->count(); if($ver!=0){echo null;}else{echo '<button type="button" class="btn btn-success btn-sm">Llenar  <i class="fa fa-users"></i></button>';}?> </a></td>

             <td><a href="/inscritos_brigada/{{$datos->id_brigada}}"><?php $dat=$datos->id_brigada; $ver = DB::table('detalle_brigadas') ->select('detalle_brigadas.id_brigada') ->where('detalle_brigadas.id_brigada', '=',$dat)->count(); if($ver==0){echo null;}else{echo '<button type="button" class="btn btn-info btn-sm">Gestionar  <i class="fa fa-users"></i></button>';}?> </a></td>


              <td><a href="/brigada_completar/{{$datos->id_brigada}}"><?php if($datos->control_brigada<$datos->cupo_brigada && $datos->control_brigada!=0){echo '<button type="button" class="btn btn-danger btn-sm">Completar  <i class="fa fa-users"></i></button>';}?></a></td>
     
            </tr>
         @endforeach
     </tbody>


  
</table>




@if($dato->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY BRIGADAS FORMADAS</h2>  

 @endif   


  </br>
   @if($info->cupo!=$det)

   <div class="container" align="center">
      <div class="form-group col-md-6" align="center">
  
 <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
 <span style="color:white;">¡actualice las brigadas!</span>
 <?php if($info->control_cupo > 0){ echo 'el grupo aún no esta completo';} ?>
    </div>

</div>
</div>

         @endif


    </br>



        </br>

</div>



  @endsection
