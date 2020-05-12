@extends('layouts.plantilla_docente')
@section('title')
: Registrar brigada
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar nueva brigada</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{ route ('docente')}}">Docente</a></li>
              <li class="breadcrumb-item active"><a href="{{ route ('brigadas_grupos')}}">grupos</a></li>
              <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">brigadas</a></li>
              <li class="breadcrumb-item active">nueva</li>
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
    @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif


<div class="container" id="font1">
</br>
<form method="POST" action="{{ route('registrar_brigadas') }}">
        @csrf

 <div class="form-row">

    <div class="form-group col-md-4">
          <label for="grupo">GRUPO</label>
          <input type="text"  value="{{$name->grupo}}" disabled  class="form-control"
          id="grupo" name="grupo">
         

       </div>

       <input type="text"  value="{{$grupo}}" hidden class="form-control"
       id="id_grupo" name="id_grupo">


      


   <div class="form-group col-md-4">
    <label for="nombre_brigada">NOMBRE DE LA BRIGADA</label>
    <input type="text" class="form-control @error('nombre_brigada') is-invalid @enderror" id="nombre_brigada" value="{{ old('nombre_brigada') }}" 
    onKeyUp="this.value = this.value.toUpperCase()" autocomplete="nombre_brigada"  name="nombre_brigada" >
     @error('nombre_brigada')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror



   </div>

    <div class="form-group col-md-4">
    <label for="cupo_brigada">N° INTEGRANTES</label>
    
    <input type="number" name="cupo_brigada" id="cupo_brigada" class="form-control">
   
   </div>
 </div>

 <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-primary">crear</button>

  </div>
</div>



</form>





</div>
 @endsection



