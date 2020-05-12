@extends('layouts.plantilla_jefe')
@section('title')
:inicio departamento
@endsection
@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family:Lucida Sans Unicode; font-weight: 900;">Bienvenido</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route ('jefe')}}">Jefe dpto</a></li>
              <li class="breadcrumb-item active">inicio</li>
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

    <div class="container">

     <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fa fa-barcode"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Total de materiales</span>
            <span class="info-box-number">{{$mat}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="ion ion-person-add"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Personal de laboratorio</span>
            <span class="info-box-number">{{$per}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fa fa-graduation-cap"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Estudiantes</span>
            <span class="info-box-number">{{$est}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-danger"><i class="fa fa-address-book"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Docentes</span>
            <span class="info-box-number">{{$doc}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <div class="col-md-12 ">
    <div class="login-or">
      <hr class="hr-or">
   </div>
 </div>
  </div>
 


 <div class="container">
 @if(isset($mate))
 <div class="container">
   <h2>Relación de materiales registrados dentro del laboratorio</h2>
  
  <div class="form-row">

    <div class="form-group col-sm-4">
      <form action="{{route ('buscar_material_home_jefe')}}" method="POST">
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
      <td style="text-align: center;"><a style="color: #306D00; font-family: Arial, Helvetica, sans-serif ;"
         href= "{{ route('actualiza_material_jefe', $material->id_material) }}"><?php if($material->tipo=='INSUMOS'){echo "Actualizar";}?></a></td>

       <td style="text-align: center;">
      <a style="color: #306D00;" href="{{ route('ver_unidades_jefe',$material->id_material )}}"><?php if($material->tipo=='INSUMOS'){echo "Ver cantidad";}else{echo "Ver unidades";}?></a></td>
                 
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
      <form action="{{route ('buscar_material_home_jefe')}}" method="POST">
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
      <th scope="col">N° SERIE</th>
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
      <td>{!! $mats->num_serie !!}</td>
      <td>{!! $mats->marca !!}</td>
      <td>{!! $mats->modelo !!}</td>
      <td>{!! $mats->tipo !!}</td>
      <td>{!! $mats->area !!}</td>

      <td style="text-align: center;"><a style="color: #306D00; font-family: Arial, Helvetica, sans-serif ;"
       href= "{{ route('actualiza_material_jefe', $mats->id_material) }}"><?php if($mats->tipo=='INSUMOS'){echo "Actualizar";}?></a></td>
       <td style="text-align: center;">
       <a style="color: #306D00;" href="{{ route('ver_unidades_jefe',$mats->id_material )}}"><?php if($mats->tipo=='INSUMOS'){echo "Ver cantidad";}else{echo "Ver unidades";}?></a></td>
          
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

<!-- Data Table Initialize -->
<script>
  $(function () {
    $('#font5').DataTable({
      responsive: true
    })
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>