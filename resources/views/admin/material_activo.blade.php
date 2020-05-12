@extends('layouts.plantilla_admin')
@section('title')
: materiales Activos
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
              <li class="breadcrumb-item active">activos</li>
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
  <h2 style= "font-family: 'Initial';">Relación de materiales registrados en el laboratorio</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">CODIGO</th>
      <th scope="col">NOMBRE</th>
      <th scope="col">N.SERIE</th>
      <th scope="col">ÁREA</th>
      <th scope="col">TIPO</th>
      <th colspan="1">ACCIONES</th>
    </tr>
  </thead>
    <tbody>
      @foreach ($activo as $inac)


      <tr>
        <th> {!! $inac->id_material !!} </th>
        <td>{!! $inac->nombre_material !!}</td>
        <td>{!! $inac->num_serie ?? 's/n' !!}</td>
        <td>{!! $inac->area !!}</td>
        <td>{!! $inac->tipo !!}</td>
    
       
             <td><a href="{{ route('desactivar_material',$inac->id_material)}}">Desactivar</a></td>
           </tr>
        @endforeach
    </tbody>


  
</table>
@if (count($activo))
  {{ $activo->links() }}
@endif





</div>





  @endsection



 
