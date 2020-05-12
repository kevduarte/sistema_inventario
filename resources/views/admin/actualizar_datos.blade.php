@extends('layouts.plantilla_admin')
@section('title')
:actualizar datos
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Actualizar Datos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
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

      <h2 style= "font-family: 'initial';">Datos generales</h2>
      <form method="POST" action="{{ route('actualizar_personas_datos') }}">
        @csrf
        <div class="form-row">

          <div class="form-group col-md-6">
            <label for="nombre" >{{ __('Nombre') }}</label>
            <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}" disabled autocomplete="nombre" autofocus oninput="calcula(this)" onkeypress="return soloLetras(event)">
            @error('nombre')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

           <input type="text"  value="{{$datos->id_persona}}" hidden class="form-control @error('id_persona') is-invalid @enderror"
       id="id_persona" name="id_persona">


         <div class="form-group col-md-6">
            <label for="rfc" >{{ __('RFC') }}</label>
            <input id="rfc" type="text" minlength="18" maxlength="18"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('rfc') is-invalid @enderror" name="rfc" value="{{ $datos->rfc }}" disabled >
            
            @error('curp')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

        </div>



        <div class="form-row">

  
          <div class="form-group col-md-6">
            <label for="telefono" >{{ __('Teléfono') }}</label>
            <input id="telefono" maxlength="10" type="tel" class="form-control @error('telefono') is-invalid @enderror"  name="telefono"  autocomplete="telefono" onkeypress="return numeros (event)" value="{{ $datos->telefono }}" placeholder="Formato a 10 dígitos">
            @error('telefono')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>





          <div class="form-group col-md-6">
            <label for="email">{{ __('Correo') }}</label>
            <input id="email" type="text" value="{{ $datos->email }}" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

        </div>




        <div class="form-group">
         <div class="col-xs-offset-2 col-xs-9" align="center">
          <button type="submit" class="btn btn-primary"><i class="fa fa-address-card"></i> actualizar</button>

        </div>
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
