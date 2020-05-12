@extends('layouts.plantilla_admin')
@section('title')
: Configuración de Contraseña
@endsection
@section('seccion')

</br>

 <div class="container" id="font1">
   </br>
      @if (Session::has('mess'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif

  <form class="form-horizontal" method="POST" action="{{ route('changedatos_admin') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
 <h1 style="color: #0B173B; font-size: 20px;" align="center"><strong>Datos personales</strong></h1>
    

       <div class="form-row">

         <div class="form-group col-md-4" >
        <label for="nombre">Nombre(s)</label>
        <input type="text" class="form-control" name="nombre" value="{{$datos_admin->nombre}} {{$datos_admin->apellido_paterno}} {{$datos_admin->apellido_materno}}" id="nombre" autocomplete="nombre" onKeyUp="this.value = this.value.toUpperCase();" disabled  >
      </div>

         <div class="form-group col-md-4">
            <label for="telefono" >{{ __('Teléfono') }}</label>
            <input id="telefono" maxlength="10" type="tel" class="form-control @error('telefono') is-invalid @enderror"  name="telefono"  autocomplete="telefono" onkeypress="return numeros (event)" value="{{ $datos_admin->telefono }}" placeholder="Formato a 10 dígitos">
            @error('telefono')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

      <div class="form-group col-md-4">
            <label for="email">{{ __('Correo') }}</label>
            <input id="email" type="text" value="{{ $datos_admin->email }}" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>


        </div>
<div class="form-group" align="center">
                                  <div class="col-md-8 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar datos
                                      </button>
                                  </div>
                              </div>
      
 </form>
   




<div class="table-responsive">
  <table class="table table-bordered" id="font2"  >
  <thead class="thead-dark">
    <tr>
      <td scope="col">  <h1 style="color: #0B173B; font-size: 20px;" alight="center"><strong>Configuración contraseña</strong></h1>
        @if (Session::has('message'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif
	  
                          <form class="form-horizontal" method="POST" action="{{ route('changePassword_admin') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
							  
                              <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                  <label for="current-password" >Contraseña Actual</label>

 <div class="col-md-12">
                                      <input id="current-password" type="password" class="form-control" name="current-password" required>

                                      @if ($errors->has('current-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('current-password') }}</strong>
                                          </span>
                                      @endif
</div>
                              </div>
							  
							  

                              <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                  <label for="new-password" >Nueva Contraseña</label>
 <div class="col-md-12">

                                      <input id="new-password" type="password" class="form-control" name="new-password" required>

                                      @if ($errors->has('new-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('new-password') }}</strong>
                                          </span>
                                      @endif

                              </div>
							  </div>

                              <div class="form-group">
                                  <label for="new-password-confirm" >Confirmar Contraseña</label>
 <div class="col-md-12">

                                      <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
</div>
                              </div>

                              <div class="form-group" align="center">
                                  <div class="col-md-8 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar Contraseña
                                      </button>
                                  </div>
                              </div>
                          </form>
	    
							  </td>


      <td scope="col">
	                            <form class="form-horizontal" method="POST" action="{{ route('changeUser_admin') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
							 
 <h1 style="color: #0B173B; font-size: 20px;"><strong>Datos de Usuario</strong></h1>
                               <div class="form-group">
                            <label for="username" >{{ __('Nombre de usuario') }}</label>

                            <div class="col-md-12">
                                <input id="username" type="text" value="{{ Auth::user()->username }}"  class="form-control @error('username') is-invalid @enderror" name="username"  required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                                        
                              <div class="form-group" align="left">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar
                                      </button>
                                  </div>
                              </div>
                          </form>
						  
	  </td>
	   
    </tr>
  </thead>
   <tbody>
    <tr> 
    </tr>
	</tbody>
</table>
</div>
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
