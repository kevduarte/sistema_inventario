@extends('layouts.plantilla_personal')
@section('title')
: materiales activos área
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Materiales Activos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Gestión de materiales</a></li>
              <li class="breadcrumb-item active">Activos</li>
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
    {{ Session::get('mess') }}
    </div>
    @endif


  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Initial';">Relación de materiales del área de: {{$area}}</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">CODIGO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">MARCA</th>
      <th scope="col">MODELO</th>
      <th scope="col">ÁREA</th>
      <th scope="col">TIPO</th>
    </tr>
  </thead>
    <tbody>
      @foreach ($activo as $inac)


      <tr>
        <th> {!! $inac->id_material !!} </th>
        <td>{!! $inac->nombre_material !!}</td>
        <td>{!! $inac->marca!!}</td>
        <td>{!! $inac->modelo!!}</td>
        <td>{!! $inac->area !!}</td>
        <td>{!! $inac->tipo !!}</td>
    
       
             
           </tr>
        @endforeach
    </tbody>


  
</table>
@if (count($activo))
  {{ $activo->links() }}
@endif

@if($activo->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">No hay registros</h2>  

 @endif  





</div>





  @endsection


 


 
