@extends('layouts.plantilla_admin')
@section('title')
:registrar materias
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Nueva materia</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Materias</a></li>
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
<form method="POST" action="{{ route('registrar_materias') }}">
        @csrf

 <div class="form-row">
   <div class="input-group col-md-6">
    <label for="area">Nombre</label><p>&nbsp; &nbsp;&nbsp;</p>
    <input type="text" class="form-control @error('materia') is-invalid @enderror" id="materia" value="{{ old('materia') }}" autocomplete="materia" onKeyUp="this.value = this.value.toUpperCase()" required name="materia" ><p>&nbsp; &nbsp; &nbsp;</p>
     @error('materia')
    <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
    </span>
    @enderror
   
    <div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Registrar</button>

</div>
</div>
   </div>

 </div>







</form>
</br>

<div class="container">
      <table class="table table-bordered" id="font5">
     <h2 style= "font-family: 'initial';">Materias registradas</h2>
    <thead class="thead-dark">
    <tr>
      <th scope="col">NOMBRE</th>
       <th colspan="2">ACCIONES</th>
 
    </tr>
  </thead>

  <tbody>
    @foreach($materias as $mate)
    <tr>
      <td style="text-align: center;">{{ $mate->materia}}</td>
      <td WIDTH="50" style="text-align: center;  " colspan="1" ><a style="color: #306D00;"
         href="{{ route('desactivar_materia',$mate->id_materia)}}" ><?php if($mate->bandera=='1'){echo "Desactivar";}?></a></td>

         <td WIDTH="50" style="text-align: center;  " colspan="1" ><a style="color: #306D00;"
         href="{{ route('activar_materia',$mate->id_materia)}}" ><?php if($mate->bandera=='0'){echo "Activar";}?> </a></td>

    </tr>

  @endforeach
   
  </tbody>
</table>
</br>

   </div>




</div>
 @endsection



