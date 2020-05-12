@extends('layouts.plantilla_docente')
@section('title')
: registrar grupos
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Registrar Grupo </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href={{ route('docente')}}>Docente</a></li>
              <li class="breadcrumb-item active">grupos</li>
                            <li class="breadcrumb-item active">registrar</li>

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
<form method="POST" action="{{ route('registrar_grupos') }}" >
        @csrf

        <div class="form-row">

         <div class="form-group col-md-4">
          <label for="grupo">Grupo</label>
          <input type="text" class="form-control @error('grupo') is-invalid @enderror" id="grupo" value="{{ old('grupo') }}" autocomplete="grupo"  name="grupo" onKeyUp="this.value = this.value.toUpperCase()" autofocus required >
           @error('grupo')
        <span class="invalid-feedback" role="alert">
         <strong>{{ $message }}</strong>
       </span>
       @enderror
        </div>
       

       <div class="form-group col-md-4">

     <label for="area">Materia</label>
   <div class="input-group ">

 <select name="materia" id="materia" required class="form-control" autocomplete="materia">
      <option value="">Seleccione un área</option>
      @foreach ($mate as $areas)
      <option value="{!! $areas->id_materia !!}"> {!! $areas->materia !!}</option>
        @endforeach
      </select>



              </div>
   
    
  </div>

        <div class="form-group col-md-4">

     <label for="area">Área de práctca</label>
   <div class="input-group ">

 <select name="area" id="area" required class="form-control" autocomplete="area">
      <option value="">Seleccione un área</option>
      @foreach ($area as $areas)
      <option value="{!! $areas->id_area !!}"> {!! $areas->area !!}</option>
        @endforeach
      </select>



              </div>
   
    
  </div>


    </div>

    <div class="form-row">

      
      <div class="form-group col-md-4">
       <label for="hora_inicio">Hora de entrada</label>
       <input class="form-control"  type="time" oninput="vamos()" min= "08:00" max="20:00" id="hora_inicio" name="hora_inicio" required>
       
     </div>

 <input type="text" class="form-control @error('hora_c') is-invalid @enderror" id="hora_c" name="hora_c" hidden>

     <div class="form-group col-md-4">
       <label for="hora_fin">Hora de salida </label>
       <input class="form-control" type="time"  onchange="vamos()"  min="" max="20:00"  value=""  id="hora_fin"  name="hora_fin" required>
     </div>

      <div class="form-group col-md-2">
      <label for="cupo" >{{ __('Cupo') }}</label>
      <input id="cupo" type="tel" maxlength="2" class="form-control @error('cupo') is-invalid @enderror" onkeypress="return numeros (event)" name="cupo" autocomplete="cupo" required autofocus>
          @error('cupo')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
          @enderror
  </div>

   </div>


   <label for="dias">Días de práctica </label>

  
  <div class="form-row">

   
       <div class="form-group col-xm-4">
  <input type="checkbox" id="lunes" name="lunes" value="Lunes" onclick="checar_lunes(this.id)" >Lunes<br>
  </div>

 <div class="form-group col-xm-4">
  <input type="checkbox" id="martes" name="martes" value="Martes" onclick="checar_martes(this.id)">Martes<br>
  </div>
 <div class="form-group col-xm-4">
  <input type="checkbox" id="miercoles" name="miercoles" value="Miercoles" onclick="checar_miercoles(this.id)" >Miércoles<br>
 </div>
 <div class="form-group col-xm-4">
  <input type="checkbox" id="jueves" name="jueves" value="Jueves"  onclick="checar_jueves(this.id)">Jueves<br>
 </div>
 <div class="form-group col-xm-4">
  <input type="checkbox" id="viernes" name="viernes" value="Viernes" onclick="checar_viernes(this.id)" >Viernes<br>
 </div>
  <div class="form-group col-xm-4">
     @if (Session::has('mes'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
     {{ Session::get('mes') }}
    </div>
    @endif
    </div>
   </div>

 
<input hidden type="text" name="lu" id="lu"  />
<input hidden type="text" name="ma" id="ma"  />
<input hidden type="text" name="mie" id="mie"  />
<input hidden type="text" name="ju" id="ju"/>
<input hidden type="text" name="vi" id="vi" />

   


   <div class="form-group">
     <div class="col-xs-offset-2 col-xs-9" align="center">
      <button type="submit" class="btn btn-primary" id="check" onclick="validar_checkbox()">Registrar</button>

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
var nuevo_minuto=parseInt(minutes);

 document.getElementById("hora_c").value = nuevo_minuto;

var primero;



if((nueva_hora >= 7) &&  (nueva_hora <= 9)){
       primero= nueva_hora + 1;
       document.getElementById("hora_fin").min = "0"+primero  + ":" + minutes;

     }

   if((nueva_hora >= 10) &&  (nueva_hora <= 20)){
          primero= nueva_hora + 1;

          document.getElementById("hora_fin").min = primero  + ":" + minutes;

        }
    if(nueva_hora == 20){
           primero= nueva_hora + 1;
           document.getElementById("hora_fin").min = primero  + ":" + minutes;

         }

}

 function checar_lunes(id){

    var checkBox = document.getElementById("lunes");
      

         if (checkBox.checked == true){
   if ( id == "lunes" ) {

        document.getElementById('lu').value = 'Lunes';
        }
  } else {

     document.getElementById('lu').value = '1';
    
  }


    }


     function checar_martes(id){

        var checkBox = document.getElementById("martes");
          if (checkBox.checked == true){
      if ( id == "martes" ) {

        document.getElementById('ma').value = 'Martes';
        

      
     }
     } else {

     document.getElementById('ma').value = '1';
    
  }
    }

 function checar_miercoles(id){
   var checkBox = document.getElementById("miercoles");
    if (checkBox.checked == true){
      if ( id == "miercoles" ) {

        document.getElementById('mie').value = 'Miercoles';
        

      
     }
      } else {

     document.getElementById('mie').value = '1';
    
  }
    }
 function checar_jueves(id){
   var checkBox = document.getElementById("jueves");
     if (checkBox.checked == true){
      if ( id == "jueves" ) {

        document.getElementById('ju').value = 'Jueves';
        

      
     }
     } else {

     document.getElementById('ju').value = '1';
    
  }
    }
 function checar_viernes(id){
   var checkBox = document.getElementById("viernes");
     if (checkBox.checked == true){
      if ( id == "viernes" ) {

        document.getElementById('vi').value = 'Viernes';
        

      
     }
     } else {

     document.getElementById('vi').value = '1';
    
  }
    }

 

 
</script>
 