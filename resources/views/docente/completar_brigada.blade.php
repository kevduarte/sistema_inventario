@extends('layouts.plantilla_docente')
@section('title')
:completar brigada
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Completar brigada: {{$nom}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="{{ route ('docente')}}">Docente</a></li>
              <li class="breadcrumb-item active"><a href="{{ route ('brigadas_grupos')}}">grupos</a></li>
              <li class="breadcrumb-item active"><a href="{{ URL::previous() }}">brigadas</a></li>
              <li class="breadcrumb-item active">completar</li>
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



 <div class="container" id="font1">
<br/>
   <form method="POST" action="{{ route('completar_estudiante_brigada') }}">
        @csrf


  <div class="form-row">
     <div class="form-group col-md-6">
    <label for="tipo">Estudiantes</label>
   <div class="input-group ">

 <select name="cambio" id="cambio" required class="form-control"  autocomplete="cambio">
      <option value="">Estudiante sin brigada</option>
      @foreach ($completar as $nombres)
      <option value="{!! $nombres->num_control !!}">N°Control: {!! $nombres->num_control !!} {!! $nombres->nombre !!} {!! $nombres->apellido_paterno !!} {!! $nombres->apellido_materno !!}</option>
        @endforeach
      </select>



              </div>

    <input type="text"  value="{{$id}}"  class="form-control" id="id_brigada" name="id_brigada" hidden>

  </div>

  </div>


 <div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">aceptar</button>

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
