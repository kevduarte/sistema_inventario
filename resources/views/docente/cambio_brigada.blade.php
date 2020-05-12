@extends('layouts.plantilla_docente')
@section('title')
:cambio brigada
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cambio de brigada </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{ route ('docente')}}">Docente</a></li>
              <li class="breadcrumb-item active"><a href="{{ route ('brigadas_grupos')}}">grupos</a></li>
              <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">brigadas</a></li>
              <li class="breadcrumb-item active">cambiar</li>
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
@if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('mess') }}
    </div>
    @endif


 

 <div class="container" id="font6" >

  <form method="POST" action="{{ route('cambiar_estudiante_brigada') }}">
        @csrf

  <div class="form-row">

        <div class="form-group col-md-4">
          <label for="nombre">Nombre</label>
          <input type="text"  value="{{$info->nombre}} {{$info->apellido_paterno}} {{$info->apellido_materno}}" disabled  class="form-control @error('nombre') is-invalid @enderror"
          id="nombre" name="nombre">
          @error('nombre')
          <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
         </span>
         @enderror

       </div>

    <input type="text"  value="{{$info->num_control}}" hidden class="form-control" id="num_control" name="num_control">


    <div class="form-group col-md-4">
    <label for="tipo">Estudiantes</label>
   <div class="input-group ">

 <select name="cambio" id="cambio" required class="form-control"  autocomplete="cambio">
      <option value="">Seleccione el estudiante por el cual cambiar</option>
      @foreach ($data as $nombres)
      <option value="{!! $nombres->num_control !!}">Brigada: {!! $nombres->nombre_brigada !!} {!! $nombres->nombre !!} {!! $nombres->apellido_paterno !!} {!! $nombres->apellido_materno !!}</option>
        @endforeach
      </select>



              </div>
  </div>

 </div>

 <div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Cambiar</button>

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
