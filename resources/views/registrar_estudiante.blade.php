@extends('layouts.plantilla_registro')
@section('title')
: registro estudiantes
@endsection

@section('seccion')

    
@if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

<div class="container mt-3" id="font2" style="background-image: url('/image/topoc (1).png'); background-size: auto; background-position:all; background-repeat: repeat; background-color: transparent ;">
</br>
</br>
@if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('mess') }}
    </div>
    @endif

<form method="POST" action="{{ route('registro_estudiante_login')}}">
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
                                  <input id="apellido_materno"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" required autocomplete="apellido_materno">
                                @error('apellido_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
</div>


 <div class="form-row">

  <div class="form-group col-md-4">
       
        <label for="num_control"style=" font-weight: bold;" >{{ __('* N. Control') }}</label>
        <input type="text" id="num_control" name="num_control" class="form-control @error('num_control') is-invalid @enderror" placeholder="Ej.1416...." onkeypress="return numero_control (event)" oninput="calcula_semes(this)" pattern="([0-9]{2}[0-9]{2}[0-9]{4})|([A-Z][0-9]{2}[0-9]{2}[0-9]{4})" title="Ingresa un número de control válido" maxlength="9" required>

         @error('num_control')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        
        </div>

     

                         <div class="form-group col-md-4">
                            <label for="semestre" style=" font-weight: bold;" >{{ __('*Semestre') }}</label>
                                <input id="semestre2" maxlength="12" type="text" class="form-control @error('semestre2') is-invalid @enderror" onkeypress="return numeros (event)" name="semestre2"  autocomplete="semestre2" required>
                                @error('semestre2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <input type="text" class="form-control @error('semestre') is-invalid @enderror"
                        id="semestre" name="semestre" hidden>



                        

                        <div class="form-group col-md-4">
                          <label for="carrera" style=" font-weight: bold;" >{{ __('*Carrera') }}</label>

                          <div class="input-group ">

                           <select name="carrera" id="carrera" required class="form-control"  autocomplete="carrera">
                            <option value="">Seleccione una carrera</option>
                            @foreach ($car as $dpto)
                            <option value="{!! $dpto->nombre !!}"> {!! $dpto->nombre !!}</option>
                            @endforeach
                          </select>



                        </div>


                      </div>


                       
</div>

 <div class="form-row">

   <div class="form-group col-md-6">
                            <label for="email" style=" font-weight: bold;">{{ __('Correo') }}</label>
                                <input id="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="container">
   <p style="color: #00024C"align="left">* campos obligatorios</p>
</div>

  </div>

   



<div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Registrar</button>

</div>
</div>



</br>



</form>



</div>



 @endsection


<script>
  function numero_control(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "áÁéÉíÍóÓúÚaAbBcCdDeEfFgGhHiIjJkKlLmMnNñÑoOpPqQrRsStTuUvVwWxXyYzZ1234567890";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

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


function calcula_semes(){
    var numero_control=document.getElementById("num_control").value;
    var se_num_control=numero_control.substring(0,2);

    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    var fecha=new Date();
    var anio=fecha.getFullYear();
    var mes=meses[fecha.getMonth()];
    junio=new String("Junio");
    //julio=new String("Julio");

if(mes<=junio){
if (numero_control == ""){
document.getElementById("semestre2").value="";
document.getElementById("semestre").value="";
} else {
var resta=(((anio-se_num_control)-2000)*2);
document.getElementById("semestre2").value=resta;
document.getElementById("semestre").value=resta;
}
} else {
if (numero_control == ""){
document.getElementById("semestre2").value="";
document.getElementById("semestre").value="";
} else {
var resta=((((anio-se_num_control)-2000)*2)+1);
document.getElementById("semestre2").value=resta;
document.getElementById("semestre").value=resta;
}
}
  }

  function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áÁéÉíÍóÓúÚaAbBcCdDeEfFgGhHiIjJkKlLmMnNñÑoOpPqQrRsStTuUvVwWxXyYzZ";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    
</script>