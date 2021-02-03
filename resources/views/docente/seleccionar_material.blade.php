@extends('layouts.plantilla_docente')
@section('title')
:seleccionar material
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Seleccionar materiales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Materiales</a></li>
              <li class="breadcrumb-item active">seleccionar</li>
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

  @if (Session::has('mes'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('mes') }}</strong>
  </div>
  @endif

  <div class="container" id="font1">
    <br>
 
    <form method="POST" action="{{ route('agregar_material') }}">
      @csrf

      <div class="form-row">


       <div class="form-group col-md-10">
        <label for="tipo">MATERIALES DISPONIBLES DEL ÁREA DE {{$area}}</label>
        <div class="input-group ">
         <select name="material" id="material" required class="select-css">
          <option value="">Seleccione los materiales a utilizar:</option>
          @foreach ($mate as $material)
          <option value="{!! $material->id_material !!}">Nombre:{!! $material->nombre_material !!}, Modelo:{!! $material->modelo !!}, Disponibles:{{$material->n_unidades}}</option>
          @endforeach
        </select>



      </div>
    </div>


        <div class="form-group col-md-2">
          <input type="text" class="form-control" id="solicitud"name="solicitud" value={{$solicitud}} hidden >
       
       </div>

  </div>

  <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-default"><i class="fa fa-shopping-cart"></i>&nbsp;Agregar a la lista</button>

  </div>
</div>

</form>


<!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 @if(isset($matcar))
 <div class="container">
  <div class="table-responsive">

  <table class="table table-bordered" id="font5">
   <h2>Relación de materiales a utilizar durante la práctica</h2>
   <thead class="thead-dark">
    <tr>

      <th scope="col">CODIGO</th>
      <th scope="col">NOMBRE MATERIAL</th>
      <th scope="col">CLAVE</th>
      <th scope="col">MODELO</th>
      <th scope="col">MARCA</th>
      <th scope="col">PIEZAS</th>
      <th scope="col">OPCIONES</th>



    </tr>
  </thead>

  <tbody>
    @foreach($matcar as $mats)
    <tr>
      <th>{{ $mats->id_material}}</td>
      <td>{{ $mats->nombre_material}}</td>
      <td>{{ $mats->clave}}</td>
      <td>{{ $mats->modelo}}</td>
      <td>{{ $mats->marca}}</td>
      <td>{{ $mats->n_unidades}}</td>
      <td><a href="{{ route ('quitar_carro',$mats->id_material)}}"><button type="button" class="btn btn-danger btn-sm">&nbsp;Quitar<i class="fa fa-trash"></i></button></a></td>
     

      
    </tr>

    @endforeach

  </tbody>

</table>
@if($matcar->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; width: auto; height: auto; align-content: center; background-color:#FFE739;">Aún no ha agregado materiales a la lista</h2>  

 @endif 
</div>
{{ $matcar->links() }}

</div>
@endif



 <br>

  <form method="POST" action="{{ route('solicitud_enviada') }}">
      @csrf

          <input type="text" class="form-control" id="numsol"name="numsol" value={{$solicitud}} hidden >
       
       

  <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i>&nbsp;Enviar solicitud</button>

  </div>
</div>

</form>

<?php  

if ($tipo=='1') {
echo ' <p style="color: #002A6C;" align="left"><span style="color: red;"><strong>nota:</strong></span> Los materiales seleccionados se asignan uno por brigada</p>';
}
if ($tipo=='2') {
  echo ' <p style="color: #002A6C;" align="left"><span style="color: red;"><strong>nota:</strong></span> Grupal</p>';
}
if ($tipo=='3') {
  echo ' <p style="color: #002A6C;" align="left"><span style="color: red;"><strong>nota:</strong></span> Individual</p>';
}

?>

  

</div>



@endsection
