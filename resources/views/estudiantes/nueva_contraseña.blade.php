@extends('layouts.plantilla_nueva')
@section('title')
: nueva contraseña
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Actualize su contraseña.</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
              <li class="breadcrumb-item active">Inicio</li>
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

<div class="container" >

  <div class="row justify-content-center" >
    <div class="col-md-8">
        <div class="card" id="font6">
           <div class="card-header" style="background-color: #CBD1EE;" align="center">{{ __('CAMBIO DE CONTRASEÑA.') }}</div>
            <div class="card-body">

   <form class="form-horizontal" method="POST" action="{{ route('cambio_contraseña') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}

                              <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                  <label for="current-password" >Contraseña Actual</label>


                                      <input id="current-password" type="password" class="form-control" name="current-password" required>

                                      @if ($errors->has('current-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('current-password') }}</strong>
                                          </span>
                                      @endif

                              </div>

                              <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                  <label for="new-password" >Nueva Contraseña</label>


                                      <input id="new-password" type="password" class="form-control" name="new-password" required>

                                      @if ($errors->has('new-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('new-password') }}</strong>
                                          </span>
                                      @endif

                              </div>

                              <div class="form-group">
                                  <label for="new-password-confirm" >Confirmar Contraseña</label>


                                      <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>

                              </div>

                              <div class="form-group" align="center">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary" name="aceptado">
                                          Actualizar Contraseña
                                      </button>
                                  </div>
                              </div>
                          </form>
                           
                            </div>
                            <div class="container">
   <p style="color: #9C9C9C"align="left">Nota: La nueva contraseña debe tener al menos 5 caracteres</p>
</div>
                        </div>
                         </div>


          
 </div>
     </div>





</br>





</div>





  @endsection

 