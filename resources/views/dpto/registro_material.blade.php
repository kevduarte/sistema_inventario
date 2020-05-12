@extends('layouts.plantilla_dpto')
@section('title')
:registrar material
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Nuevo material</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Gestión de materiales</a></li>
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

<div class="container" id="font1">
</br>
<form method="POST" action="{{ route('registrar_materiales') }}">
  @csrf
  <div class="form-row" align="center">

    <div class="form-group col-md-4">
      <label for="id_materiales">Código</label>
      <input type="text" class="form-control @error('id_materiales') is-invalid @enderror" id="id_materiales" value="{{ old('id_materiales') }}" autocomplete="id_materiales"  name="id_materiales" onKeyUp="this.value = this.value.toUpperCase()" disabled >

      <input type="text" class="form-control @error('id_material') is-invalid @enderror" id="id_material" name="id_material" hidden>
      @error('id_material')
      <span class="invalid-feedback" role="alert">
       <strong>¡El codigo del material ya ha sido registrado!</strong>
     </span>
     @enderror


   </div>
   
   <div class="radio col-md-6">
    <label style="font-size: 1.0em; font-family:Arial;">Clasificación</label>
    <div  align="center">

     <input type="radio" id="si_material" name="mate" value="" onclick="checar(this.id)" oninput="limpiar();" required >
     <label style="font-size: 1.0em; font-family:Arial;" for="si_actividad">&nbsp;Material o equipo</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

     <input type="radio" id="no_material" name="mate" value="33055" onclick="nochecar(this.id)" oninput="mostrar();" required>
     <label style="font-size: 1.0em; font-family:Arial;" for="no_actividad">&nbsp;Consumibles</label>
   </div>

 </div>






</div>

<hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->

<div class="form-row">


 <div class="form-group col-md-4">
  <label for="nombre">* Nombre</label>
  <input type="text" class="form-control @error('nombre') is-invalid @enderror"  id="nombre_material" name="nombre_material" value="{{ old('nombre_material') }}" required autocomplete="nombre_material" onKeyUp="this.value = this.value.toUpperCase()">
  @error('nombre_material')
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror
</div>

<div class="form-group col-md-4" id="serie">
  <label for="num_serie">* N° serie </label>
  <input type="text" class="form-control @error('num_serie') is-invalid @enderror" id="serie" value="{{ old('num_serie') }}" autocomplete="num_serie"  name="num_serie" onKeyUp="this.value = this.value.toUpperCase()" autofocus>
  @error('num_serie')
  <span class="invalid-feedback" role="alert">
   <strong>{{ $message }}</strong>
 </span>
 @enderror
</div>



<div class="form-group col-md-4" id="mode">
  <label for="modelo">Modelo</label>
  <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{ old('modelo') }}" onKeyUp="this.value = this.value.toUpperCase()" autocomplete="modelo">
  @error('modelo')
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror

</div>


</div>

<div class="form-row">

  <div class="form-group col-md-4">
    <label for="marca">*Marca</label>
    <input type="text" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{ old('marca') }}" onKeyUp="this.value = this.value.toUpperCase()"  autocomplete="marca">
     @error('marca')
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror

  </div>


<div class="form-group col-md-4" id="tip">
  <label for="tipo">* Categoría</label>
  <div class="input-group ">

   <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" oninput="mostrar_id_material();" autocomplete="tipo">
    <option value="">Seleccione una categoría</option>
    @foreach ($tipos_disponibles as $tipos)
    <option value="{!! $tipos->id_tipo !!}"> {!! $tipos->tipo !!}</option>
    @endforeach
  </select>
  @error('tipo')
  <span class="invalid-feedback" role="alert">
    <strong>El campo categoria es obligatorio</strong>
  </span>
  @enderror
</div>
</div>

 <div class="form-group col-md-4" id="are">

   <label for="area">* Área</label>
   <div class="input-group ">

     <select name="area" id="area" class="form-control @error('area') is-invalid @enderror" oninput="areas_mostrar();"  autocomplete="area">
      <option value="">Seleccione un área</option>
      @foreach ($areas_disponibles as $areas)
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


<div class="form-row">

  <div class="form-group col-md-4">
    <label for="clave">Clave</label>
    <input type="text" class="form-control @error('clave') is-invalid @enderror" id="clave" name="clave" value="{{ old('clave') }}" autocomplete="clave" onKeyUp="this.value = this.value.toUpperCase()" >
    @error('clave')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>



  

  <div class="form-group col-md-8">
    <label for="descripcion">Descripción</label>
    <textarea class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" rows="2" cols="80"></textarea>
  </div>
 @error('descripcion')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror


</div>

<div class="form-row">





 <div class="form-group col-md-4" hidden>
  <label for="unidades">Unidades</label>
  <input type="tel" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="1" onkeypress="return numeros (event)">
   @error('cantidad')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror

</div>

<div class="form-group col-md-4" id="tot" >
  <label for="total">*Cantidad</label>
  <input type="tel" name="total" id="tot" class="form-control @error('total') is-invalid @enderror" onkeypress="return numeros (event)">
   @error('total')
    <span class="invalid-feedback" role="alert">
      <strong>El campo cantidad es obligatorio </strong>
    </span>
    @enderror
</div>

<div class="form-group col-md-4"  id="labels">
  <label for="medida">*Unidad de medida</label>
  <select name="medida" id="labels" class="form-control @error('medida') is-invalid @enderror">
   <option value="">Seleccione una opción</option>
   <option value="Kilo">Kilo</option>
   <option value="Bulto">Bulto</option>
   <option value="Gramo">Gramo</option>
   <option value="Metro lineal">Metro lineal</option>
   <option value="Metro cuadrado">Metro cuadrado</option>
   <option value="Metro cúbico">Metro cúbico</option>
   <option value="Pieza">Pieza</option>
   <option value="Cabeza">Cabeza</option>
   <option value="Litro">Litro</option>
   <option value="Par">Par</option>
   <option value="Kilowatt">Kilowatt</option>
   <option value="Millar">Millar</option>
   <option value="Juego">Juego</option>
   <option value="Tonelada">Tonelada</option>
   <option value="Galón">Galón</option>
   <option value="Decenas">Decenas</option>
   <option value="Cientos">Cientos</option>
   <option value="Docenas">Docenas</option>
   <option value="Caja">Caja</option>
   <option value="Botella">Botella</option>
 </select>
   @error('medida')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>


</div>


<div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i> registrar</button>

</div>
</div>



</form>


<div class="container">
 <p style="color: #00024C"align="left">* campos obligatorios</p>
</div>


</div>

<script type="text/javascript">


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


  function mostrar_id_material(){
    const checar = document.getElementById('tipo').value;

    document.getElementById('id_material').value = '4'+ checar;
    document.getElementById('id_materiales').value = '4'+ checar;

  }

  function mostrar(){
    const checar = document.getElementById('no_material').value;

    document.getElementById('id_material').value ='4'+checar;
    document.getElementById('id_materiales').value ='4'+checar;


  }

  function limpiar(){
    const checar = document.getElementById('si_material').value;

    document.getElementById('id_material').value ='4'+checar;
    document.getElementById('id_materiales').value ='4'+checar;


  }



  function areas_mostrar(){
    const checar = document.getElementById('area').value;
    const valor_actual = document.getElementById('id_material').value;
    const tome_valores = valor_actual.substring(0,3) + ''+ valor_actual.substring(3,4) ;

    document.getElementById('id_material').value = tome_valores + '' + checar;
    document.getElementById('id_materiales').value = tome_valores + '' + checar;

  }

  function checar(id){
   if ( id == "si_material" ) {

      document.getElementById("tot").setAttribute("hidden","hidden");
   document.getElementById("labels").setAttribute("hidden","hidden");

   document.getElementById("serie").removeAttribute("hidden");
   document.getElementById("mode").removeAttribute("hidden");
   document.getElementById("tip").removeAttribute("hidden");
   document.getElementById("are").removeAttribute("hidden");

  }
}

function nochecar(id){
  if ( id == "no_material" ) {

   document.getElementById("serie").setAttribute("hidden","hidden");
   document.getElementById("mode").setAttribute("hidden","hidden");
      document.getElementById("tip").setAttribute("hidden","hidden");
         document.getElementById("are").setAttribute("hidden","hidden");

                document.getElementById("tot").removeAttribute("hidden");
                document.getElementById("labels").removeAttribute("hidden");




 }

}
</script>
@endsection



