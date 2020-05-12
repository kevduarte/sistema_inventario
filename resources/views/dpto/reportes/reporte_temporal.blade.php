@extends('layouts.plantilla_dpto')
@section('title')
:reporte temporal
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Baja temporal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Reportes</a></li>
              <li class="breadcrumb-item active">baja temporal</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class="container">
 
 <div class="container">
  <label for="nombre"><span style="font-size: 1.0em; font-family:Constantia; font-weight: 900;"> Buscar por:</span></label></br>
 </div>


   <div class="form-row">
&nbsp;&nbsp;&nbsp;
  <div class="form-group col-xm-4">
  <input type="radio" id="bnombre" name="bnombre" value="bnombre" onclick="checar_nombre(this.id)"><span style="font-size: 1.0em; font-family:Constantia; font-weight: 900;">nombre</span><br>
  </div>
 <div class="form-group col-xm-4">
  <input type="radio" id="btipo" name="bnombre" value="bnombre" onclick="checar_tipo(this.id)"><span style="font-size: 1.0em; font-family:Constantia; font-weight: 900;">categoría</span><br>
  </div>
 <div class="form-group col-xm-4">
  <input type="radio" id="barea" name="bnombre" value="bnombre" onclick="checar_area(this.id)" ><span style="font-size: 1.0em; font-family:Constantia; font-weight: 900;">área</span><br>
 </div>
  </div>
   
<div class="form-row">


  &nbsp;&nbsp;&nbsp;
  <div class="form-group col-sm-4">

   <form action="{{route ('buscar_material')}}" method="POST" id="busca" hidden>
     {{ csrf_field() }}
     <div class="form-row">
       <div class="input-group ">
        <input type="text" class="form-control" id="buscador" name="buscador" required autofocus placeholder="nombre"><p>&nbsp;</p>
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit"><span>&nbsp;
            <i class="fa fa-search" ></i></span>
          </button>
        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </div>
    </div>
  </form>

  <form action="{{route ('buscar_materialtipo')}}" method="POST" id="tipo" hidden>
   {{ csrf_field() }}
   <div class="form-row">

    <div class="input-group ">
      <input type="text" class="form-control" id="buscadortipo"name="buscadortipo" required placeholder="tipo"><p>&nbsp;</p>
      <span class="input-group-btn">
        <button class="btn btn-primary" type="submit"><span>&nbsp;
          <i class="fa fa-search" ></i></span>
        </button>
      </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
  </div>
</form>

<form action="{{route ('buscar_materialarea')}}" method="POST" id="area" hidden>
 {{ csrf_field() }}
 <div class="form-row">

  <div class="input-group ">
    <input type="text" class="form-control" id="buscadorarea" name="buscadorarea" required placeholder="area"><p>&nbsp;</p>
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


@if (Session::has('message'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('message') }}</strong>
</div>
@endif
@if (Session::has('mess'))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ Session::get('mess') }}
</div>
@endif

<!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 <div class="container">
 @if(isset($activo))
     <div class="container">
      <table class="table table-bordered" id="font5">
     <h2 style= "font-family: 'initial';">Relación de materiales con unidades que presentan baja temporal</h2>
    <thead class="thead-dark">
    <tr>
      
      <th scope="col">NOMBRE</th>
      <th scope="col">CÓDIGO</th>

      <th scope="col">MARCA</th>
      <th scope="col">CLAVE</th>
      <th scope="col">MODELO</th>

      <th colspan="1">OPCIONES</th>


    </tr>
  </thead>

  <tbody>
    @foreach($activo as $mats)
    <tr>
      <th>{{ $mats->nombre_material}}</th>
      <td>{{ $mats->id_material}}</td>

      <td>{{ $mats->marca ?? 's/m'}}</td>
      <td>{{ $mats->clave ?? 's/c'}}</td>
      <td>{{ $mats->modelo ?? 's/m'}}</td>
    
      <td><a style="color:blue;" href="{{ route('ver_temporales',$mats->id_material )}}">Ver detalles<i class="fa fa-eye"></i></a></td>
    </tr>

  @endforeach
   
  </tbody>
</table>
{{ $activo->links() }}
   </div>
     @endif
   </br>
</div>

<!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 <div class="container">
 @if(isset($details))
     <div class="container">
      <table class="table table-bordered" id="font2">
     <h2>Materiales relacionados con la búsqueda</h2>
    <thead class="thead-dark">
    <tr>
      <th scope="col">NOMBRE</th>
      <th scope="col">CODIGO</th>
      <th scope="col">MARCA</th>
      <th scope="col">CLAVE</th>
      <th scope="col">MODELO</th>
      <th scope="col">CATEGORIA</th>
      <th scope="col">ÁREA</th>
      <th colspan="4">OPCIONES</th>

    </tr>
  </thead>

  <tbody>
    @foreach($details as $mats)
    <tr>
      <th>{{ $mats->nombre_material}}</th>
      <td>{{ $mats->id_material}}</td>
      <td>{{ $mats->marca ?? 's/m'}}</td>
      <td>{{ $mats->clave ?? 's/c'}}</td>
      <td>{{ $mats->modelo ?? 's/m'}}</td>
      <td>{{ $mats->tipo}}</td>
      <td>{{ $mats->area}}</td>
      <td><a style="color:blue;" href="{{ route('detalles_material',$mats->id_material )}}">Ver detalles<i class="fa fa-eye"></i></a></td>
      <td><a style="color:red;" href="{{ route('desactivar_material',$mats->id_material)}}">Desactivar material<i class="fa fa-eraser"></i></a></td>
    </tr>

  @endforeach
   
  </tbody>
</table>
{{ $details->links() }}
   </div>
     @endif
</div>

<!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 <div class="container">
   @if(isset($detail))
     <div class="container">
      <table class="table table-bordered" id="font2">
     <h2 style= "font-family: 'initial';">Materiales relacionados con la búsqueda</h2>
    <thead class="thead-dark">
    <tr>
       <th scope="col">CATEGORIA</th>
       <th scope="col">NOMBRE</th> 
      <th scope="col">CODIGO</th>
      <th scope="col">CLAVE</th>
      <th scope="col">MODELO</th>
      <th scope="col">MARCA</th>
      <th scope="col">ÁREA</th>
      <th colspan="4">OPCIONES</th>

    </tr>
  </thead>

  <tbody>
    @foreach($detail as $mats)
    <tr>
     <th>{{ $mats->tipo}}</th>
     <td>{{ $mats->nombre_material}}</td>
     <td>{{ $mats->id_material}}</td>
     <td>{{ $mats->clave ?? 's/c'}}</td>
     <td>{{ $mats->modelo ?? 's/m'}}</td>
     <td>{{ $mats->marca ?? 's/m'}}</td>
     <td>{{ $mats->area}}</td>
     <td><a style="color:blue;" href="{{ route('detalles_material',$mats->id_material )}}">Ver detalles<i class="fa fa-eye"></i></a></td>
      <td><a style="color:red;" href="{{ route('desactivar_material',$mats->id_material)}}">Desactivar material<i class="fa fa-eraser"></i></a></td>
        
    </tr>

  @endforeach
   
  </tbody>
</table>
 {{ $detail->links() }}
   </div>  
     @endif

  </div>

  <!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 <div class="container">
   @if(isset($detaila))
     <div class="container">
      <table class="table table-bordered" id="font2">
     <h2 style= "font-family: 'initial';">Materiales relacionados con la búsqueda</h2>
    <thead class="thead-dark">
    <tr>
       <th scope="col">ÁREA</th>

       <th scope="col">CATEGORIA</th>
       <th scope="col">NOMBRE</th>
      
      <th scope="col">CODIGO</th>
      
      <th scope="col">CLAVE</th>
      <th scope="col">MODELO</th>
     
     
      <th scope="col">MARCA</th>
      
      <th colspan="4">OPCIONES</th>

    </tr>
  </thead>

  <tbody>
    @foreach($detaila as $mats)
    <tr>
      <th>{{ $mats->area}}</th>
       <td>{{ $mats->tipo}}</td>
        <td>{{ $mats->nombre_material}}</td>
      <td>{{ $mats->id_material}}</td>

      
       <td>{{ $mats->clave ?? 's/c'}}</td>
       <td>{{ $mats->modelo ?? 's/m'}}</td>
       
      
        
        <td>{{ $mats->marca ?? 's/m'}}</td>
       
     <td><a style="color:blue;" href="{{ route('detalles_material',$mats->id_material )}}">Ver detalles<i class="fa fa-eye"></i></a></td>
      <td><a style="color:red;" href="{{ route('desactivar_material',$mats->id_material)}}">Desactivar material<i class="fa fa-eraser"></i></a></td>        
    </tr>

  @endforeach
   
  </tbody>
</table>
 {{ $detaila->links() }}
   </div>

      
    
     @endif

  </div>
 
 @endsection
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

<script language="JavaScript">
    function checar_area(id){
      if ( id == "barea" ) {
          document.getElementById("area").removeAttribute("hidden");

       document.getElementById("tipo").setAttribute("hidden","hidden");
       document.getElementById("busca").setAttribute("hidden","hidden");
      
     }
    }
     function checar_tipo(id){
      if ( id == "btipo" ) {
         document.getElementById("tipo").removeAttribute("hidden");
         document.getElementById("area").setAttribute("hidden","hidden");
         document.getElementById("busca").setAttribute("hidden","hidden");
      
     }
    }
     function checar_nombre(id){
      if ( id == "bnombre" ) {
        
       document.getElementById("busca").removeAttribute("hidden");
       document.getElementById("tipo").setAttribute("hidden","hidden");
       document.getElementById("area").setAttribute("hidden","hidden");
      
     }
    }
</script>