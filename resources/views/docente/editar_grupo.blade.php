@extends('layouts.plantilla_docente')
@section('title')
: actualizar grupos
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Actualizar Grupo </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href={{ route('docente')}}>Docente</a></li>
              <li class="breadcrumb-item active"><a  href={{ route('mis_grupos')}}>grupos</a></li>
                <li class="breadcrumb-item active">actualizar</li>
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
<form method="POST" action="{{ route('actualiza_grupos') }}">
        @csrf

        <div class="form-row">

     <div class="form-group col-md-3">
    <label for="grupo">GRUPO</label>
     <input type="text" class="form-control @error('grupo') is-invalid @enderror" id="grupo" value="{{ $dato->grupo}}" autocomplete="grupo"  name="grupo" onKeyUp="this.value = this.value.toUpperCase()" disabled required >
     </div>
        @error('grupo')
        <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
       </span>
       @enderror

  <input id="grupo" hidden type="text" name="grupo" value="{{$dato->grupo}}" required >


          <input id="id_grupo" hidden type="text" name="id_grupo" value="{{$dato->id_grupo}}" required >
       
       <div class="form-group col-md-3">
        <label for="materia">MATERIA</label>
    <input type="text" class="form-control @error('materia') is-invalid @enderror"  id="materia" name="materia" value="{{$dato->materia}}" disabled required autocomplete="materia" onKeyUp="this.value = this.value.toUpperCase()">
        @error('materia')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <input id="materia" hidden type="text" name="materia" value="{{$dato->materia}}" required >

<div class="form-group col-md-3">
        <label for="cupo" >{{ __('Cupo') }}</label>
        <input id="cupo" disabled type="tel" maxlength="3" value="{{$dato->cupo}}" class="form-control @error('cupo') is-invalid @enderror" onkeypress="return numeros (event)" name="cupo"  required autofocus>
        @error('cupo')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        <label for="cupo" >{{ __('Horario') }}</label>
        <input id="horario" disabled type="horario" value="<?php if(empty($dato->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($dato->hora_inicio));}?>-<?php if(empty($dato->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i", strtotime($dato->hora_fin));}?> hrs." class="form-control @error('horario') is-invalid @enderror" onkeypress="return numeros (event)" name="horario">
        @error('horario')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
  

      

    </div>
    <div class="form-row">

      <div class="form-group col-md-3">
        <label for="control_cupo" >{{ __('Lugares Disponibles') }}</label>
        <input id="control_cupo"  disabled type="tel" maxlength="3" value="{{$dato->control_cupo}}" class="form-control @error('control_cupo') is-invalid @enderror" onkeypress="return numeros (event)" name="control_cupo"  required autofocus>
        @error('control_cupo')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        <label for="aumento" >{{ __('* Aumentar Cupo') }}</label>
        <input id="aumento"  type="tel" maxlength="3"  class="form-control" value="0" onkeypress="return numeros (event)" name="aumento"  required >
    </div>

      

   </div>

   


   <div class="form-group">
     <div class="col-xs-offset-2 col-xs-9" align="center">
      <button type="submit" class="btn btn-primary">actualizar</button>

    </div>
  </div>



</form>


</br>





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

function vamos(){
    var ed = document.getElementById('hora_inicio').value; 
    var hours = ed.split(":")[0];
   var minutes = ed.split(":")[1];
var nueva_hora= parseInt(hours);
var primero;
if((nueva_hora >= 6) &&  (nueva_hora <= 8)){
       primero= nueva_hora + 1;
       document.getElementById("hora_fin").min = "0"+primero  + ":" + minutes;

     }

   if((nueva_hora >= 9) &&  (nueva_hora <= 19)){
          primero= nueva_hora + 1;
          document.getElementById("hora_fin").min = primero  + ":" + minutes;

        }
    if(nueva_hora == 20){
           primero= nueva_hora + 1;
           document.getElementById("hora_fin").min = primero  + ":" + minutes;

         }

}


</script>
 