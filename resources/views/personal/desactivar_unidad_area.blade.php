@extends('layouts.plantilla_personal')
@section('title')
:desactivar unidad
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Desactivar unidad</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('ver_unidades_area',$unidad->id_material )}}">unidades</a></li>
          <li class="breadcrumb-item active">desactivar</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
@if (Session::has('message'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif



<h2 style= "font-family: 'Segoe UI';">Desactivar del registro la unidadd: {{$unidad->codigo_unidad}} </h2>
    <div class="container" id="font1">
  


    </br>
    <form method="POST" action="{{ route('baja_unidad_area') }}">
   
      @csrf
      
    


      <div class="form-row">

        <div class="form-group col-md-6">
          <label for="codigo_unidad">CODIGO UNIDAD</label>
          <input type="text"  value="{{$unidad->codigo_unidad}}" disabled  class="form-control @error('codigo_unidad') is-invalid @enderror"
          id="codigo_unidad" name="codigo_unidad">
          @error('codigo_unidad')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror

       </div>
         <input type="text"  value="{{$unidad->codigo_unidad}}" hidden class="form-control @error('codigo_unidad') is-invalid @enderror"
       id="codigo_unidad" name="codigo_unidad">

         <div class="form-group col-md-6">
        <label for="nombre">NOMBRE</label>
        <input type="text" value="{{$unidad->nombre_material}}" disabled class="form-control @error('nombre_material') is-invalid @enderror" id="nombre_material" name="nombre_material">
        @error('nombre_material')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <input type="text" value="{{$unidad->nombre_material}}" hidden class="form-control @error('nombre_material') is-invalid @enderror" id="nombre_material" 
      name="nombre_material">
     </div>


      <div class="form-row">

       <input type="text"  value="{{$unidad->id_material}}" hidden class="form-control @error('id_material') is-invalid @enderror"
       id="id_material" name="id_material">

      <div class="form-group col-md-12">
  <label for="observaciones">MOTIVO</label>
  <textarea class="form-control" onKeyUp="this.value = this.value.toUpperCase()" required name="observaciones" id="observaciones" value="{{ old('observaciones') }}" rows="2" cols="80"></textarea>
</div>


      </div>






  <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-primary">baja</button>

  </div>
</div>
<div class="container">
   <p style="color: #002A6C"align="center">*nota: registre el motivo por el cual dará de baja la unidad</p>
</div>

</form>



</div>

@endsection