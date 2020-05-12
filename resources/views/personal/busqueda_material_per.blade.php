@extends('layouts.plantilla_personal')
@section('title')
: Búsqueda Materiales
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Buscar Materiales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Gestión de materiales</a></li>
              <li class="breadcrumb-item active">Buscar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


 

<div class="container">

   <div class="form-row">

    <div class="form-group col-sm-6">

       <form action="{{route ('buscar_material_per')}}" method="POST">
     {{ csrf_field() }}
      <div class="form-row">
 <label for="nombre"> Buscar por nombre</label>
        <div class="input-group ">
<input type="text" class="form-control" name="buscador" required autofocus placeholder="Buscar material"><p>&nbsp;</p>
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><span>&nbsp;
                <i class="fa fa-search" ></i></span>
                   </button>
                </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         </div>
 </div>
 </form>
</div>



 </div>
</div>

<!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 <div class="container">
     @if (Session::has('message'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

 @if(isset($details))
     <div class="container">
      <table class="table table-bordered" id="font2">
     <h2 style= "font-family: 'initial';">Materiales relacionados con la búsqueda</h2>
    <thead class="thead-dark">
    <tr>
      <th scope="col">CODIGO</th>
      <th scope="col">N_SERIE</th>
      <th scope="col">NOMBRE</th>
      
      <th scope="col">CLAVE</th>
      <th scope="col">MODELO</th>
      <th scope="col">TIPO</th>
      <th scope="col">ÁREA</th>

      <th scope="col">MARCA</th>
    
      <th scope="col">DESCRIPCIÓN</th>
      <th scope="col">OPCIONES</th>

    </tr>
  </thead>

  <tbody>
    @foreach($details as $mats)
    <tr>
      <th scope="row">{{ $mats->id_material}}</th>
    
     <td>{{ $mats->num_serie ?? 's/n'}}</td>

       <td>{{ $mats->nombre_material}}</td>
       <td>{{ $mats->clave ?? 's/c'}}</td>
       <td>{{ $mats->modelo ?? 's/m'}}</td>
       
       <td>{{ $mats->tipo}}</td>
        <td>{{ $mats->id_area}}</td>
        <td>{{ $mats->marca ?? 's/m'}}</td>
     
        <td>{{ $mats->descripcion ?? 's/d'}}</td>
        <td><a style="color: #306D00;" href="{{ route('detalles_material_per',$mats->id_material )}}">Detalles<i class="fa fa-eye"></i></a></td>
        
    </tr>

  @endforeach
   
  </tbody>
</table>
   </div>
@if (count($details))
       {{ $details->links() }}
     @endif
     @endif
</div>
 
 @endsection

