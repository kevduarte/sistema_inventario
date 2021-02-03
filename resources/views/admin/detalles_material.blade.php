@extends('layouts.plantilla_admin')
@section('title')
:detalles materiales
 @endsection

 @section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Materiales</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin')}}">Materiales</a></li>

              <li class="breadcrumb-item active">detalles</li>
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


    <!-- Default box -->
    <div class="card card-solid">
      <div class="card-body">
        <div class="row">
         
          <div class="col-12 col-sm-6">
            <div class="row">
             
              <div class="col">
               <h4>Categoría</h4>
               <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option1" autocomplete="off" checked="">
                  
                  {{$tipo}}
                  <br>
                  
                </label>
              </div>
            </div>
            <div class="col">
              <h4>Área designada</h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center active">
                  <input type="radio" name="color_option" id="color_option1" autocomplete="off" checked="">
                  {{$area}}
                  <br>
                  
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-6">
          <h3 class="my-3">{{$nombre}}</h3>
          <p>{{$info}}</p>

          <hr>

          <div class="bg-gray py-2 px-3 mt-4">
            <h2 class="mb-0">
              Total de unidades:
            </h2>
            <h4 class="mt-0">
              <small>{{$num}} </small>
            </h4>
          </div>

        </div>
        
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->




</div>





  @endsection


 
