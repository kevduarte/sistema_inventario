@extends('layouts.plantilla_dpto')
@section('title')
:actualizar insumo
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Actualizar Insumo.</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('departamento') }}">Materiales</a></li>
          <li class="breadcrumb-item active">actualizar</li>
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

 <div class="container" id="font1">
 </br>
    <form method="POST" action="{{ route('actualizar_material_insumo') }}">
   
      @csrf
      <div class="form-row">

        <div class="form-group col-md-4">
          <label for="id_material">CODIGO</label>
          <input type="text"  value="{{$material->id_material}}" disabled  class="form-control @error('id_material') is-invalid @enderror"
          id="id_material" name="id_material">
          @error('id_material')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror

       </div>

       <input type="text"  value="{{$material->id_material}}" hidden class="form-control @error('id_material') is-invalid @enderror"
       id="id_material" name="id_material">



       <div class="form-group col-md-4">
        <label for="nombre">Nombre</label>
        <input type="text" value="{{$material->nombre_material}}" disabled class="form-control @error('nombre_material') is-invalid @enderror" id="nombre_material" name="nombre_material">
        @error('nombre_material')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <input type="text" value="{{$material->nombre_material}}" hidden class="form-control @error('nombre_material') is-invalid @enderror" id="nombre_material" 
      name="nombre_material">



 </div>


    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="modelo">Modelo</label>
        <input type="text"  value="{{$material->modelo}}" disabled class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo">
         @error('modelo')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

      </div>


      <div class="form-group col-md-4">
        <label for="tipo">Tipo</label>
        <input type="text" value="{{$material->tipo}}" disabled class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo">
         @error('tipo')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>
        <input type="text" value="{{$material->tipo}}" hidden class="form-control @error('tipo') is-invalid @enderror" id="tipo" name="tipo">

      <div class="form-group col-md-4">
        <label for="area">Área</label>
        <input type="text" value="{{$material->area}}" disabled class="form-control @error('area') is-invalid @enderror" id="area" name="area">
        @error('area')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

      </div>
      <input type="text" value="{{$material->area}}" hidden class="form-control @error('area') is-invalid @enderror" id="area" name="area">

    </div>

        <div class="form-row">
      <div class="form-group col-md-4">
        <label for="marca">Marca</label>
        <input type="text" value="{{$material->marca}}" disabled class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca">

        @error('marca')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

      </div>
     
    </div>

              <div class="form-row">


      <div class="form-group col-md-4">
  <label for="cantidad">Agregar cantidad</label>
 <input type="tel" name="cantidad" id="cantidad" class="form-control" onkeypress="return numeros (event)">

</div>

    <div class="form-group col-md-4">
        <label for="total">Cantidad existentes</label>
        <input type="text"  value="{{$uni->total}}" disabled class="form-control @error('total') is-invalid @enderror" id="total" name="total">
         @error('total')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

      </div>

       <div class="form-group col-md-4">
        <label for="medida">Unidad de medida</label>
        <input type="text"  value="{{$med->medida}}" disabled class="form-control @error('medida') is-invalid @enderror" id="medida" name="medida">
         @error('medida')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror

      </div>
            </div>


  


  <div class="form-group">
   <div class="col-xs-offset-2 col-xs-9" align="center">
    <button type="submit" class="btn btn-primary">actualizar</button>

  </div>
</div>
<div class="container">
   <p style="color: #002A6C"align="center"> <span style="color: red;"><strong>nota: </strong></span>actualizar los campos en blanco</p>
</div>

</form>



</div>

@endsection

<script>
function numeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = "8-37-39-46";

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
</script>
