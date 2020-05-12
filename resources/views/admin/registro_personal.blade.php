@extends('layouts.plantilla_admin')
@section('title')
:registrar personal
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Nuevo personal</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
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


    <div class="container" id="font1">

      <h2 style= "font-family: 'initial';">Datos generales</h2>
      <form method="POST" action="{{ route('registrar_personal') }}">
        @csrf
        <div class="form-row">

          <div class="form-group col-md-4">
            <label for="nombre" >{{ __('*Nombre(s)') }}</label>
            <input id ="NOMBRE_PERSONA" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus onchange="calculaRFC();" onkeypress="return soloLetras(event)">
            @error('nombre')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="form-group col-md-4">
            <label for="apellido_paterno" >{{ __('*Apellido Paterno') }}</label>
            <input id ="APELLIDO_PATERNO" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno" onchange="calculaRFC();" onkeypress="return soloLetras(event)">
            @error('apellido_paterno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="form-group col-md-4">
            <label for="apellido_materno" >{{ __('*Apellido Materno') }}</label>
            <input id ="APELLIDO_MATERNO"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" autocomplete="apellido_materno" onchange="calculaRFC();" onkeypress="return soloLetras(event)">
            @error('apellido_materno')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>



        <div class="form-row">

          <div class="form-group col-md-4">
            <label for="rfc" >{{ __('*RFC') }}</label>
            <input id="RFC"  name="rfc" type="text" onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('rfc') is-invalid @enderror" value="{{ old('rfc') }}" required  oninput="validarInput(this)" 
       placeholder="Ingrese su RFC" >
            
            <pre id="resultado"></pre>
            @error('rfc')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>


          <div class="form-group col-md-4">
            <label for="telefono" >{{ __('Teléfono') }}</label>
            <input id="telefono" maxlength="10" type="tel" class="form-control @error('telefono') is-invalid @enderror"  name="telefono"  autocomplete="telefono" onkeypress="return numeros (event)" placeholder="Formato a 10 dígitos">
            @error('telefono')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>





          <div class="form-group col-md-4">
            <label for="email">{{ __('Correo') }}</label>
            <input id="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" name="email" autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

        </div>




        <div class="form-group">
         <div class="col-xs-offset-2 col-xs-9" align="center">
          <button type="submit" class="btn btn-primary"><i class="fa fa-address-card"></i> registrar</button>

        </div>
      </div>




    </form>
    <div class="container">
     <p style="color: #002A6C"align="left">*campos obligatorios</p>
   </div>



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

function calculaRFC() {
  function quitaArticulos(palabra) {
    return palabra.replace("DEL ", "").replace("LAS ", "").replace("DE ",
        "").replace("LA ", "").replace("Y ", "").replace("A ", "");
  }
  function esVocal(letra) {
    if (letra == 'A' || letra == 'E' || letra == 'I' || letra == 'O'
        || letra == 'U' || letra == 'a' || letra == 'e' || letra == 'i'
        || letra == 'o' || letra == 'u')
      return true;
    else
      return false;
  }

  nombre = $("#NOMBRE_PERSONA").val().toUpperCase();

  apellidoPaterno = $("#APELLIDO_PATERNO").val().toUpperCase();

  apellidoMaterno = $("#APELLIDO_MATERNO").val().toUpperCase();


  var rfc = "";

  apellidoPaterno = quitaArticulos(apellidoPaterno);
  apellidoMaterno = quitaArticulos(apellidoMaterno);

  rfc += apellidoPaterno.substr(0, 1);

  var l = apellidoPaterno.length;
  var c;
  for (i = 0; i < l; i++) {
    c = apellidoPaterno.charAt(i);
    if (esVocal(c)) {
      rfc += c;
      break;
    }
  }

  rfc += apellidoMaterno.substr(0, 1);

  rfc += nombre.substr(0, 1);



  // rfc += "-" + homclave;

  $("#RFC").val(rfc);

}


//Función para validar un RFC
// Devuelve el RFC sin espacios ni guiones si es correcto
// Devuelve false si es inválido
// (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,

    //Obtener el digito esperado
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}


//Handler para el evento cuando cambia el input
// -Lleva la RFC a mayúsculas para validarlo
// -Elimina los espacios que pueda tener antes o después
function validarInput(input) {
    var rfc         = input.value.trim().toUpperCase(),
        resultado   = document.getElementById("resultado"),
        valido;
        
    var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba
  
    if (rfcCorrecto) {
      valido = "Válido";
      resultado.classList.add("ok");
    } else {
      valido = "No válido"
      resultado.classList.remove("ok");
    }
        
    resultado.innerText = "RFC: " + rfc 
                        + "\nResultado: " + rfcCorrecto
                        + "\nFormato: " + valido;
}

</script>