@extends('layouts.home')
@section('titulo')
:laborato civil
@endsection

@section('seccion')

<div class="container mt-3" id="font2" style="background-image: url('/image/topoc (1).png'); background-size: auto; background-position:all; background-repeat: repeat; background-color: transparent ;">

  <br>
  <h6 >Bienvenido</h6>
  @if (Session::has('mess'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ Session::get('mess') }}</strong>
  </div>
  @endif

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card" style="color: #001539">
          <div class="card-header"> <h5>Acceder</h5></div>
          
          @if (Session::has('message'))
          <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('message') }}</strong>
          </div>
          @endif
           @if (Session::has('messa'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ Session::get('messa') }}</strong>
          </div>
          @endif
          


          <div class="card-body" >
            <form method="POST" action= "{{ route('login_usuarios')}} ">
              @csrf

              <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                <div class="col-md-6">
                  <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                  @error('username')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                  <input type="checkbox" onclick="myFunction()"> ver
                  
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              

              
              <div class="form-group">
                <div class="col-md-8 offset-md-5">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Acceder') }}
                  </button>
                   </div>
                   <div class="col-md-8 offset-md-4" align="justify-content-center">
                  @if (Route::has('password.request'))
                  <a class="btn btn-link" href="{{ route('password.request') }}">
                   {{ __('¿olvidaste tu contraseña?') }}
                 </a>
                 @endif
               </div>

               


             </div>
           </form>

           <div class="col-md-12 ">
            <div class="login-or">
             <hr class="hr-or">

           </div>
         </div>

           <div class="col-md-8 offset-md-4" align="justify-content-center">

              <span style="font-size: 11px; line-height: 1.9em;
          margin-bottom: 5px; font-family: 'Arial', cursive;
          font-size: 1.0em; font-weight: normal; color:#003794; " class="ml-2">¿No tienes una cuenta?</span>
                  <a class="btn btn-link" href="{{ route('registro_estudiante')}}">
                  Registrate
                 </a>
                 
               </div>


       


     </div>
     <!-- Remind Passowrd -->


   </div>
 </div>
</div>
</div>
</br>
</br>







</div>





@endsection

<script>
  function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>