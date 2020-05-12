@extends('layouts.plantilla_admin')
@section('title')
: Registro estudiantes
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar Estudiante</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
              <li class="breadcrumb-item active">registrar</li>
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


<div class="container mt-3" id="font1">
</br>
<form method="POST" action="">
        @csrf

   <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="nombre" style=" font-weight: bold;">{{ __('* Nombre(s)') }}</label>
                                <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_paterno" style=" font-weight: bold;" >{{ __('* Apellido Paterno') }}</label>
                                  <input id="apellido_paterno" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno">
                                @error('apellido_paterno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_materno" style=" font-weight: bold;" >{{ __('* Apellido Materno') }}</label>
                                  <input id="apellido_materno"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" autocomplete="apellido_materno">
                                @error('apellido_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
</div>


 <div class="form-row">

     <div class="form-group col-md-4">
                            <label for="matricula" style=" font-weight: bold;" >{{ __('* N. Control') }}</label>
                                  <input id="matricula"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula') }}" autocomplete="matricula">
                                @error('matricula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                         <div class="form-group col-md-4">
                            <label for="semestre" style=" font-weight: bold;" >{{ __('*Semestre') }}</label>
                                <input id="semestre" maxlength="12" type="text" class="form-control @error('semestre') is-invalid @enderror"  name="semestre"  autocomplete="semestre" required>
                                @error('semestre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                         <div class="form-group col-md-4">
                            <label for="carrera" style=" font-weight: bold;" >{{ __('*Carrera') }}</label>
                                  <input id="carrera"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('carrera') is-invalid @enderror" name="carrera" value="{{ old('carrera') }}" autocomplete="carrera">
                                @error('carrera')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                       
</div>

   

<div class="form-row">
  <div class="form-group col-md-6">
    <label for="email" style=" font-weight: bold;">{{ __('* Correo electrónico') }}</label>
        <input id="email" type="text"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>


</div>


<div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Registrar</button>

</div>
</div>

<div class="container">
   <p style="color: #002A6C"align="left">*Campos obligatorios</p>
</div>

</br>



</form>



</div>



 @endsection


