@extends('layouts.plantilla_admin')
@section('title')
: creacion cuenta docente
@endsection

@section('seccion')

<div class="container">

  <div class="row justify-content-center">
      <div class="col-md-8">
          <div class="card">
              <div class="card-header" align="center">{{ __('Mensaje Nuevo') }}</div>

              <div class="card-body">
                <form method="POST" action="{{route('aprobar_cuenta_docente') }}">
                @csrf


    <div class="form-group row">
        <label for="nombre" class="col-md-4 col-form-label text-md-right" >{{ __('Nombre de docente') }}</label>

        <div class="col-md-6">
          <input id="nombre" type="text" value="{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control" name="nombre" disabled >
            @error('nombre')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>

         <input type="text" value="{{$datos->nombre}} " hidden class="form-control @error('id_cuenta') is-invalid @enderror"
       id="nombre" name="nombre">

<input type="text" value=" {{$datos->apellido_paterno}} " hidden class="form-control @error('apellido_paterno') is-invalid @enderror"
       id="apellido_paterno" name="apellido_paterno">

        <input type="text" value=" {{$datos->apellido_materno}}" hidden class="form-control @error('apellido_materno') is-invalid @enderror"
       id="apellido_materno" name="apellido_materno">

     <input type="text"  value="{{$datos->id_cuenta}}" hidden class="form-control @error('id_cuenta') is-invalid @enderror"
       id="id_cuenta" name="id_cuenta">

     <input type="text"  value="{{$datos->curp}}" hidden class="form-control @error('curp') is-invalid @enderror"
       id="curp" name="curp">
       <input type="text"  value="{{$datos->departamento}}" hidden class="form-control @error('departamento') is-invalid @enderror"
       id="departamento" name="departamento">


    <div class="form-group row">
        <label for="id_user" class="col-md-4 col-form-label text-md-right" >{{ __('Correo:') }}</label>
        <div class="col-md-6">
            <input id="email" type="email" value="{{$datos->email}}" onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('email') is-invalid @enderror" name="email" disabled>
            @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>
     <input type="text"  value="{{$datos->email}}" hidden class="form-control @error('email') is-invalid @enderror"
       id="email" name="email">
   
        <div class="form-group row">
        <label for="asunto" class="col-md-4 col-form-label text-md-right" >{{ __('Asunto:') }}</label>
        <div class="col-md-6">
            <input id="asunto" name="asunto" type="text" value="Cuenta aprobada" class="form-control" required >
            @error('asunto')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>

   

    <div class="form-group row">
        <label for="contenido" class="col-md-4 col-form-label text-md-right" >{{ __('Contenido del Mensaje:') }}</label>
        <div class="col-md-6">
            <textarea id="contenido" name="contenido" rows="6" style="resize: both;" class="form-control" required ></textarea>
            @error('contenido')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
    </div>

<div class="form-group">
    <div class="col-xs-offset-2 col-xs-9" align="center">
        <button type="submit" class="btn btn-primary">
          {{ __('Enviar Notificación') }}
        </button>
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>

@endsection