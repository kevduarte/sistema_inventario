@extends('layouts.plantilla_dpto')
@section('title')
:alta personal
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Alta personal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
              <li class="breadcrumb-item active">alta</li>
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
</br>
<form method="POST" action="{{ route('alta_personal_nueva_dpto') }}">
   @csrf
        
   <div class="form-row">

    <div class="form-group col-md-6">
      <label for="nombre">*Nombre</label>
      <div class="input-group ">
       <select name="nombre" id="nombre" required class="form-control @error('nombre') is-invalid @enderror">
        <option value="">Seleccione un nombre</option>
        @foreach ($alta as $altas)
        <option value="{!! $altas->id_persona !!}">{!! $altas->nombre !!} {!! $altas->apellido_paterno!!} {!! $altas->apellido_materno !!}</option>
        @endforeach
      </select>
      @error('nombre')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="form-group col-md-6">
      <label for="personal">*Puesto</label>
      <div class="input-group ">

       <select name="personal" id="personal" required class="form-control @error('personal') is-invalid @enderror" onclick="checar(this.id)" oninput="limpiar();">
        <option value="">Seleccione una puesto</option>
        @foreach ($tipo as $personals)
        <option value="{!! $personals->id !!}"> {!! $personals->tipo !!}</option>
        @endforeach
      </select>
      @error('personal')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

    </div>
  </div>

 


</div>

  

<div class="form-row">

<div class="form-group col-md-4">
    <label for="username" >{{ __('*Nombre de usuario') }}</label>
        <input id="username" type="text"  class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

 <div class="form-group col-md-4" id="tipo" hidden>
      <label for="area"> *Área</label>
      <div class="input-group ">
       <select name="area" id="area" class="form-control @error('area') is-invalid @enderror">
        <option value="">Seleccione un área</option>
        @foreach ($area as $areas)
        <option value="{!! $areas->id_area !!}"> {!! $areas->area !!}</option>
        @endforeach
      </select>
      @error('area')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror

    </div>
  </div>



</div>

 


<div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">registrar</button>

</div>
</div>



</form>

<div class="container">
<p style="Times New Roman, Times, serif, cursive; color: #000000" >
  <span style="color: #000001;"><strong>* campos obligatorios.</strong></span>
</p>
</div>



</div>



 @endsection

<script type="text/javascript">
  
  function checar(id){

  const checar = document.getElementById('personal').value;

   if ( checar == "2" ) {
    
    document.getElementById("tipo").removeAttribute("hidden");
        

  }
}

 function limpiar(){
    const checar = document.getElementById('personal').value;

    if ( checar != "2" ) {

 document.getElementById("tipo").value="";     
    
 document.getElementById("tipo").setAttribute("hidden","hidden");
        

  }

  }


</script>