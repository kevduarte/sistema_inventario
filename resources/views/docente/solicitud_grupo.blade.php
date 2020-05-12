  @extends('layouts.plantilla_docente')
  @section('title')
  :datos de la solicitud
  @endsection

  @section('seccion')

  <!-- Content Header (Page header) -->
  <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Datos de la solicitud</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="">Docente</a></li>
          <li class="breadcrumb-item active"><a  href="">grupos</a></li>
          <li class="breadcrumb-item active">solicitud</li>
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

  @if (Session::has('mess'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {{ Session::get('mess') }}
  </div>
  @endif

  <div class="col-md-12 ">
  <div class="login-or">
   <hr class="hr-or">

  </div>
  </div>

  <div class="container">
  <h2 style= "font-family: 'Initial';">SOLICITUD DE MATERIAL PARA EL ÁREA DE {{$dato->area}}</h2>

  <br>
  <form method="POST" action="{{ route('solicitud_enviar') }}">
   {{ csrf_field() }}


   <div class="form-row">

     <div class="form-group col-md-4">
      <label for="grupo">Grupo</label>
      <input type="text" class="form-control @error('grupo') is-invalid @enderror" id="grupo" value="{{ $dato->grupo}}" autocomplete="grupo"  name="grupo" onKeyUp="this.value = this.value.toUpperCase()" disabled required >
      @error('grupo')
      <span class="invalid-feedback" role="alert">
       <strong>{{ $message }}</strong>
     </span>
     @enderror
   </div>




   <input id="grupo" hidden type="text" name="grupo" value="{{$dato->grupo}}">
   <input id="id_docente" hidden type="text" name="id_docente" value="{{$idc}}">

   <input id="id_grupo" hidden type="text" name="id_grupo" value="{{$dato->id_grupo}}">
   <input id="materia" hidden type="text" name="materia" value="{{$dato->materia}}"  >
   <input id="hora_inicio" hidden type="text" name="hora_inicio" value="<?php if(empty($dato->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i ", strtotime($dato->hora_inicio));}?>"  >
   <input id="hora_fin" hidden type="text" name="hora_fin" value="<?php if(empty($dato->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i ", strtotime($dato->hora_fin));}?>"  >




   <div class="form-group col-md-4">
    <label for="materia">Materia</label>
    <input type="text" class="form-control @error('materia') is-invalid @enderror"  id="materia" name="materia" value="{{$dato->materia}}" disabled required autocomplete="materia" onKeyUp="this.value = this.value.toUpperCase()">
    @error('materia')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>


  <div class="form-group col-md-4">
    <label for="nombre" >{{ __('Docente') }}</label>
    <input id="nombre"  disabled type="text" value="{{$nombre}} {{$ap}}" class="form-control @error('nombre') is-invalid @enderror" onkeypress="return numeros (event)" name="nombre" autofocus>
    @error('nombre')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>



  </div>

  <div class="form-row">



  <div class="form-group col-md-4">
  <label for="hora" >{{ __('Horario') }}</label>
  <input id="hora"  disabled type="text" value="<?php if(empty($dato->hora_inicio)){ $vacio=null; echo $vacio;} else{ echo date("H:i ", strtotime($dato->hora_inicio));}?>-<?php if(empty($dato->hora_fin)){ $vacio=null; echo $vacio;} else{ echo date("H:i ", strtotime($dato->hora_fin));}?>hrs" class="form-control @error('hora') is-invalid @enderror" onkeypress="return numeros (event)" name="hora" autofocus>
  @error('hora')
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
  </div>


  <div class="form-group col-md-4">
  <label for="grupo">Fecha préstamo</label>
  <input id="dia"  type="text" name="dia" value="{{$nueva}}" class="form-control" disabled>
  @error('dia')
  <span class="invalid-feedback" role="alert">
   <strong>{{ $message }}</strong>
  </span>
  @enderror
  </div>
  <input id="dia"  type="text" hidden name="dia" value="{{$nueva}}">



  <div class="form-group col-md-4">
  <label for="area">*Tipo préstamo</label>
  <div class="input-group ">
  <select name="prestamo" id="prestamo" required class="form-control" autocomplete="prestamo">
    <option value="">Seleccione un area</option>
    @foreach ($presta as $prestas)
    <option value="{!! $prestas->id_prestamo !!}"> {!! $prestas->tipo_prestamo !!}</option>
    @endforeach
  </select>
  </div> 
  </div>



  </div>

  <div class="form-row">

  <div class="form-group col-md-4" hidden>
   <label for="grupo">Fecha solicitud</label>
   <input id="fecha_prestamo" type="text" value="{{$fecha->format('Y-m-j')}}" class="form-control @error('fecha_prestamo') is-invalid @enderror" name="fecha_prestamos" disabled>
   @error('fecha_prestamo')
   <span class="invalid-feedback" role="alert">
     <strong>{{ $message }}</strong>
   </span>
   @enderror
  </div>
   <input id="fecha_prestamo" hidden type="text" name="fecha_prestamo" value="{{$fecha->format('Y-m-j')}}"  >


     <input id="area" hidden type="text" name="area" value="{{$areas}}"  >




  </div>










  <div class="form-group">
  <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary"><i class="fa fa-caret-right"></i>  continuar</button>

  </div>
  </div>



  </form>


  </br>





  </div>



  @endsection
