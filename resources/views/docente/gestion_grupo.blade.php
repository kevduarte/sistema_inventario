@extends('layouts.plantilla_docente')
@section('title')
:gestión de grupos
@endsection

@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">GRUPO: {{$detalle->grupo}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('docente')}}">Docente</a></li>
              <li class="breadcrumb-item"><a  href="{{ route('mis_grupos')}}">grupos</a></li>
                <li class="breadcrumb-item active">gestionar</li>
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
<div class="row">

  <div class="col-sm-12" align="right">
      <a class="btn btn-info" href="/lista_inscritos/{{$forma->id_grupo}}/{{$forma->id_docente}}" target="_blank"><i class="fa fa-file"></i><span>&nbsp;Lista</span></a>   
  </div>
  
</div>
   
    
      <div class="table-responsive">

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family:Arial;">Estudiantes inscritos</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">N°</th>
      <th scope="col">NOMBRE</th>
            <th scope="col">N° CONTROL</th>

       <th scope="col">ESTATUS</th>

       

     
      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
      @foreach($data as $indice => $detalles)
       <tr>
              <td >{{$indice+1}}</td>
              <td>{{$detalles->apellido_paterno}} {{$detalles->apellido_materno}} {{$detalles->nombre}} </td>
                            <td >{{$detalles->num_control}}</td>

                 <td>{{$detalles->estado}}</td>
                  
          <td ><a href="/desactivar_estudiante_grupo/{{$detalles->id_grupo}}/{{$detalles->num_control}}"><?php if($detalles->estado=='cursando'){echo "<span style='height:auto; font-size:12px;' class='right badge badge-danger'>Dar de baja</span>";}?></a></td>

      <td ><a href="/activar_estudiante_grupo/{{$detalles->id_grupo}}/{{$detalles->num_control}}"><?php if($detalles->estado=='baja'){echo "<span style='height:auto; font-size:12px;' class='right badge badge-success'>Activar</span>";}?></a></td>
            

             
      
            </tr>
         
         @endforeach
         
           
          
     </tbody>  
</table>

</div>

@if (count($data))
  {{ $data->links() }}
@endif



@if($data->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">AÚN NO HAY ESTUDIANTES INSCRITOS</h2>  

 @endif   



</div>



  @endsection
