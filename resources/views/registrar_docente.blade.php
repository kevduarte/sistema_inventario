@extends('layouts.plantilla_registro')
@section('title')
: Inicio
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar Docente</h1>
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


<div class="container mt-3" id="font2" style="background-image: url('image/topoc (1).png'); background-size: auto; background-position:all; background-repeat: repeat; background-color: transparent ;">
</br>
<form method="POST" action="{{ route('solicitar_cuenta') }}">
        @csrf

   <div class="form-row">

                       <div class="form-group col-md-4">
                            <label for="nombre" style=" font-weight: bold;" >{{ __('* Nombre(s)') }}</label>
                                <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus oninput="calcula(this)" onkeypress="return soloLetras(event)">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_paterno" style=" font-weight: bold;" >{{ __('* Apellido Paterno') }}</label>
                                  <input id="apellido_paterno" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno" oninput="calcula(this)" onkeypress="return soloLetras(event)">
                                @error('apellido_paterno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_materno" style=" font-weight: bold;" >{{ __('* Apellido Materno') }}</label>
                                  <input id="apellido_materno"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" required autocomplete="apellido_materno" oninput="calcula(this)" onkeypress="return soloLetras(event)">
                                @error('apellido_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
</div>


 <div class="form-row">

     <div class="form-group col-md-4">
  <label for="curp" style=" font-weight: bold;" >{{ __('* CURP') }}</label>
  <input id="curp" type="text" minlength="18" maxlength="18" pattern="[A-Z](A|E|I|O|U|X)[A-Z]{2}\d{6}(H|M)(AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[A-Z]{3}([A-Z][0-9]|[A-Z]{2}|[0-9]{2})" title="La curp que intentas ingresar no es válido."    onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('curp') is-invalid @enderror" name="curp" value="{{ old('curp') }}" required >
  <pre id="resultado"></pre>
  @error('curp')
  <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
  </span>
  @enderror

</div>

<div class="form-group col-md-4">
  <label for="departamento" style=" font-weight: bold;" >{{ __('*Departamento') }}</label>

  <div class="input-group ">

   <select name="departamento" id="departamento" required class="form-control"  autocomplete="departamento">
    <option value="">Seleccione un departamento</option>
    @foreach ($dep as $dpto)
    <option value="{!! $dpto->departamento !!}"> {!! $dpto->departamento !!}</option>
    @endforeach
  </select>



</div>


</div>



                       <div class="form-group col-md-4">
                            <label for="email" style=" font-weight: bold;">{{ __('*Correo') }}</label>
                                <input id="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
<div class="container">
   <p style="color: #000000"align="left">* campos obligatorios</p>
</div>

                       
</div>


   



<div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Enviar</button>

</div>
</div>



<div class="container">
<p style="Times New Roman, Times, serif, cursive; color: #000000" >
  <span style="color: red;"><strong>NOTA: </strong></span>
  Al enviar los datos registrados se notificara al encargado del laboratorio sobre la solicitud de la cuenta, una vez aceptada recibiras un
   <span style="color: #004BB1"><strong> Correo</strong> </span>de confirmación a la dirección proporcionada con tu nombre de usuario y contraseña</p>
</div>

</br>



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

    function calcula(){
      A=new String("A","a","á");
      E=new String("E","e","é");
      I=new String("I","i","í");
      O=new String("O","o","ó");
      U=new String("U","u","ú");

      var ap_paterno=document.getElementById("apellido_paterno").value;
      var uno_ap_pat=ap_paterno.substring(0,1);

      var ap_materno=document.getElementById("apellido_materno").value;
      var uno_ap_mat=ap_materno.substring(0,1);

      var nombr=document.getElementById("nombre").value;
      var nom=nombr.substring(0,1);

      var dos_ap_pat=ap_paterno.substring(1,2);
      var tres_ap_pat=ap_paterno.substring(2,3);
      var cuatro_ap_pat=ap_paterno.substring(3,4);
      var cinco_ap_pat=ap_paterno.substring(4,5);
      var seis_ap_pat=ap_paterno.substring(5,6);

      if(dos_ap_pat== A || dos_ap_pat== E || dos_ap_pat== I || dos_ap_pat== O || dos_ap_pat== U){
         document.getElementById("curp").value=uno_ap_pat.concat(dos_ap_pat,uno_ap_mat,nom);
      }
      else if(tres_ap_pat== A || tres_ap_pat== E || tres_ap_pat== I || tres_ap_pat== O || tres_ap_pat== U){
        document.getElementById("curp").value=uno_ap_pat.concat(tres_ap_pat,uno_ap_mat,nom);
      }
      else if(cuatro_ap_pat== A || cuatro_ap_pat== E || cuatro_ap_pat== I || cuatro_ap_pat== O || cuatro_ap_pat== U){
        document.getElementById("curp").value=uno_ap_pat.concat(cuatro_ap_pat,uno_ap_mat,nom);
      }
      else if(cinco_ap_pat== A || cinco_ap_pat== E || cinco_ap_pat== I || cinco_ap_pat== O || cinco_ap_pat== U){
        document.getElementById("curp").value=uno_ap_pat.concat(cinco_ap_pat,uno_ap_mat,nom);
      }
      else {
        document.getElementById("curp").value=uno_ap_pat.concat(seis_ap_pat,uno_ap_mat,nom);
      }
    }
</script>