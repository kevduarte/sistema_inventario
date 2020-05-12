@extends('layouts.plantilla_personal')
@section('title')
: Inicio personal
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
              <li class="breadcrumb-item"><a href="#">Encargados</a></li>
              <li class="breadcrumb-item active">inicio</li>
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


 <div class="container">
 @if(isset($mate))
 <div class="container">
   <h2>Relación de materiales registrados dentro del área de:{{$arean->area}}</h2>
  
  <div class="form-row">

    <div class="form-group col-sm-4">
      <form action="{{route ('buscar_material_homep')}}" method="POST">
       {{ csrf_field() }}
       <div class="form-row">
         <div class="input-group">
          <input type="text" class="form-control" name="buscador" onKeyUp="this.value = this.value.toUpperCase()" required autofocus placeholder="nombre...">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>      
      </div>
    </form>
  </div>
</div>
</div>
 @if (Session::has('mess'))
   <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    {{ Session::get('mess') }}
  </div>
  @endif

<table class="table table-bordered" id="font5">
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">CÓDIGO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">MARCA</th>
      <th scope="col">MODELO</th>
      <th scope="col">CATEGORÍA</th>
      <th scope="col">ÁREA</th>
      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>


  <tbody>
    @foreach($mate as $material)
    <tr>
      <th>{!! $material->id_material !!}</th>
      <td>{!! $material->nombre_material !!}</td>
      <td>{!! $material->marca !!}</td>
      <td>{!! $material->modelo !!}</td>              
      <td>{!! $material->tipo !!}</td>
      <td>{!! $material->area !!}</td>

       <td style="text-align: center;">
      <a style="color: #306D00;" href="{{ route('ver_unidades_area',$material->id_material )}}"><?php if($material->tipo=='INSUMOS'){echo "Ver cantidad";}else{echo "Ver unidades";}?></a></td>
                 
    </tr>
  @endforeach   
  </tbody>
</table>
{{ $mate->links() }}
@endif
</div>


  <!--ESTA TABLA TABLA APARECE CUANDO SE HACE LA BUSQUEDA -->
 <div class="container">
@if(isset($info))
<div class="container">
   <h2 style= "font-family: 'Initial';">Materiales relacionados con la búsqueda</h2>
  <div class="form-row">
    <div class="form-group col-sm-4" >
      <form action="{{route ('buscar_material_home')}}" method="POST">
       {{ csrf_field() }}
       <div class="form-row">
         <div class="input-group">
          <input type="text" class="form-control" name="buscador" onKeyUp="this.value = this.value.toUpperCase()" required autofocus placeholder="nombre...">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>  
      </div>
    </form>
  </div>
</div>
</div>
  <table class="table table-bordered" id="font5">  
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">CÓDIGO</th>
      <th scope="col">MARCA</th>
      <th scope="col">MODELO</th>
      <th scope="col">CATEGORÍA</th>
      <th scope="col">ÁREA</th>
      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>


  <tbody>
     @foreach($info as $mats)
    <tr>
      <th>{!! $mats->nombre_material !!}</th>
      <td>{!! $mats->id_material !!}</td>
      <td>{!! $mats->marca !!}</td>
      <td>{!! $mats->modelo !!}</td>
      <td>{!! $mats->tipo !!}</td>
      <td>{!! $mats->area !!}</td>

       <td style="text-align: center;">
       <a style="color: #306D00;" href="{{ route('ver_unidades_area',$mats->id_material )}}"><?php if($mats->tipo=='INSUMOS'){echo "Ver cantidad";}else{echo "Ver unidades";}?></a></td>
          
    </tr>
  @endforeach
   
  </tbody>
  </table>
  @if (count($info))
       {{ $info->links() }}
  @endif
  @endif

</div>
    
  @endsection
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>

