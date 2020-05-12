@extends('layouts.plantilla_estudiante')
@section('title')
: incripción grupo
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Inscripcion al grupo: {{$clave->grupo}}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('grupos_disponibles')}}">Grupos</a></li>
          <li class="breadcrumb-item active">inscribirse</li>
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

    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('mess') }}
    </div>
    @endif





    <div class="container" id="font1">


    </br>
    <form method="POST" action="{{ route('nueva_inscripcion') }}">
   
      @csrf
      
    


      <div class="form-row">

        <div class="form-group col-md-4">
          <label for="grupo">GRUPO</label>
          <input type="text"  value="{{$clave->grupo}}" disabled  class="form-control @error('grupo') is-invalid @enderror"
          id="grupo" name="grupo">
          @error('grupo')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror

       </div>
        <input type="text"  value="{{$clave->grupo}}" hidden class="form-control @error('grupo') is-invalid @enderror"
       id="grupo" name="grupo">


        <input type="text"  value="{{$clave->id_grupo}}" hidden class="form-control @error('id_grupo') is-invalid @enderror"
       id="id_grupo" name="id_grupo">

    
    <input type="number" value="{{$clave->control_cupo}}" name="control_cupo" id="control_cupo" hidden class="form-control">
   
   

      


       <div class="form-group col-md-4">
        <label for="materia">Materia</label>
        <input type="text" value="{{$clave->materia}}" disabled class="form-control @error('materia') is-invalid @enderror" id="materia" name="materia">
        @error('materia')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

    <input type="text" value="{{$clave->materia}}" hidden class="form-control @error('materia') is-invalid @enderror" id="materia" 
      name="materia">



      <div class="form-group col-md-4">
        <label for="clave">Contraseña grupo</label>
        <input type="text" onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('clave') is-invalid @enderror" 
        id="clave" name="clave" required>
         @error('clave')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
      
 </div>


   
      

  <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-primary">inscribirse</button>

  </div>
</div>

<div class="container">
<p style="Times New Roman, Times, serif, cursive; color: #000000" >
  <span style="color: red;"><strong>NOTA: </strong></span>
  si no conoce la 
   <span style="color: #004BB1"><strong> Contraseña</strong> </span>del grupo solicítala con el docente, de lo contrario <span style="color:red"><strong> No</strong> </span>podrá inscribirse</p>
</div>

</form>



</div>

@endsection