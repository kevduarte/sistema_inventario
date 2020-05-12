@extends('layouts.plantilla_admin')
@section('title')
: Registrar tipos
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Registrar categoría</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Categoría</a></li>
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


<div class="container" id="font1">
</br>
<form method="POST" action="{{ route('registrar_tipos') }}">
        @csrf

 <div class="form-row">
   <div class="input-group col-md-6">
    <label for="tipo">Nombre</label><p>&nbsp; &nbsp;&nbsp;</p>
    <input type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo" value="{{ old('tipo') }}"
    onKeyUp="this.value = this.value.toUpperCase()" autocomplete="tipo"  name="tipo" required><p>&nbsp; &nbsp; &nbsp;</p>
     @error('tipo')
    <span class="invalid-feedback" role="alert">
     <strong>Ingrese una categoría</strong>
    </span>
    @enderror



   </div>
   <div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Registrar</button>

</div>
</div>
 </div>





</form>

<div class="container">
      <table class="table table-bordered" id="font5">
     <h2 style= "font-family: 'Initial';">Lista de Categorías de materiales</h2>
    <thead class="thead-dark">
    <tr>
      <th scope="col">CÓDIGO CATEGORÍA</th>
      <th scope="col">NOMBRE</th>
    </tr>
  </thead>

  <tbody>
    @foreach($tipos as $tipo)
    <tr>
      <td style="text-align: center;">{{ $tipo->id_tipo}}</th>
      <td style="text-align: center;">{{ $tipo->tipo}}</td>
    </tr>

  @endforeach
   
  </tbody>
</table>
@if (count($tipos))
  {{ $tipos->links() }}
@endif

</br>
   </div>




</div>
 @endsection



