@extends('layouts.plantilla_docente')
@section('title')
:brigadas
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Gestionar brigadas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('docente')}}">Docente</a></li>
              <li class="breadcrumb-item active">grupos</li>
               <li class="breadcrumb-item active">brigadas</li>
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
    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif

    
  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Initial';">Grupos registrados durante el periodo: {{$detalle}}</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th style="width: auto;;">GRUPO</th>
      <th scope="col">MATERIA</th>
      <th scope="col">ÁREA DE PRÁCTICA</th>
    
      
            
     

     
      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
       @foreach ($dato as $datos)
       <tr >
              
              <th>{{$datos->grupo}}</th>
              <td>{{$datos->materia}}</td>
              <td>{{$datos->area}}</td>

              
             
                        
             <td><a href="/brigadas_formadas/{{$datos->id_grupo}}/{{$datos->id_docente}}"><?php $dat=$datos->id_grupo; $ver = DB::table('brigadas') ->select('brigadas.id_brigada') ->where('brigadas.id_grupo', '=',$dat)->count(); if($ver==0){echo null;}else{echo '<button type="button" class="btn btn-info btn-sm">Ver brigadas  <i class="fa fa-eye"></i></button>';}?> </a></td>


             

               <td><a href="/formar_brigadas/{{$datos->id_grupo}}/{{$datos->id_docente}}"><button onclick="return confirmation()" type="button" class="btn btn-success btn-sm">Formar brigadas   <i class="fa fa-briefcase"></i></button></a></td>
     
     
     
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
<script type="text/javascript">
     function confirmation() 
     {
        if(confirm("Desea formar brigadas para este grupo?"))
  {
     return true;
  }
  else
  {
     return false;
  }
     }


    </script>