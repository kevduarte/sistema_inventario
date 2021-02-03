@extends('layouts.plantilla_admin')
@section('title')
: Personal inactivos
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Personal del laboratorio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
              <li class="breadcrumb-item active">Inactivos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


   <div class="container">

@if (Session::has('message'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif


  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Segoe UI';">-Personal inactivo del laboratorio-</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">PUESTO</th>
       <th scope="col">ÁREA</th>
      <th scope="col">NOMBRE-USUARIO</th>
      
      <th colspan="4">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
      @foreach ($personal as $encargados)
      <tr>
        <th scope="row"> {!! $encargados->nombre !!} {!! $encargados->apellido_paterno !!} {!! $encargados->apellido_materno !!}</th>
        <td>{!! $encargados->cargo !!}</td>
        <td>{!! $encargados->area !!}</td>
        <td>{!! $encargados->username !!}</td>
       
             <td><a href="{{ route('activar_personal',$encargados->id_user)}}">ACTIVAR</a></td>
           </tr>
        @endforeach
    </tbody>


  
</table>
@if (count($personal))
  {{ $personal->links() }}
@endif

@if($personal->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY REGISTROS</h2>  

 @endif   




</div>



  @endsection
