@extends('layouts.plantilla_docente')
@section('title')
:solicitar material
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Solicitudes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Solicitudes</a></li>
              <li class="breadcrumb-item active">material</li>
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

  <table class="table table-bordered" id="font2">
    <h2  style= "font-family: 'initial';">Lista de solicitudes</h2>
 
   <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
            <th scope="col">MATERIA</th>

      <th style="width: auto;;">GRUPO</th>
     
      
          
            
       <th scope="col">MATERIAL</th>
       
    </tr>
  </thead>
   <tbody>
       @foreach ($vale as $vales)
       <tr >
              
              <td>{{$vales->area}}</td>
              <td>{{$vales->grupo}}</td>
              <td>{{$vales->nombre_material}}</td>
               

              
              
     
            </tr>
         @endforeach
     </tbody>


  
</table>



</div>



  @endsection
