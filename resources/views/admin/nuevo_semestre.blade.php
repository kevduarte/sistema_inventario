@extends('layouts.plantilla_admin')
@section('title')
: nuevo semestre
@endsection

@section('seccion')

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Registrar Nuevo Semestre</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Semestre</a></li>
              <li class="breadcrumb-item active">nuevo</li>
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
<form  method="POST" action="{{route ('agregar_semestre')}}">
   {{ csrf_field() }}
    <div class="form-row">


       <div class="form-group col-md-4">
    <label for="inicio" >{{ __('Fecha de inicio') }}</label>
    <input id="inicio" type="date"  name="inicio"  class="form-control"  required min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>
    </div>

    <div class="form-group col-md-4">
      <label for="final" >{{ __('Fecha Final') }}</label>
      <input id="final" type="date"  onchange="calcula()" name="final"class="form-control"  required min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>
            </div>

        <div class="form-group col-md-4">
      <label for="nombre" >{{ __('Nombre') }}</label>
      <input id="nombre" type="text"  name="nombre"class="form-control"  required>
            </div>
  
  

              </div>

               <div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
  <button type="submit" class="btn btn-primary">Registrar</button>

</div>
</div>

            
              
              

</form>

<div class="container">
      <table class="table table-bordered" id="font2">
     <h2 style= "font-family: 'initial';">SEMESTRES REGISTRADOS</h2>
    <thead class="thead-dark">
    <tr>
      <th scope="col">INICIO</th>
      <th scope="col">FIN</th>
      <th scope="col">ESTADO</th>
      <th scope="col">NOMBRE</th>
      
     

    </tr>
  </thead>

  <tbody>
    @foreach($lista as $mats)
    <tr>
      <td style="text-align: center;">{{ date('d-m-Y', strtotime($mats->inicio_semestre))}}</td>
             <td style="text-align: center;">{{ date('d-m-Y', strtotime($mats->final_semestre))}}</td>

       <td style="text-align: center;">{{ $mats->estatus_semestre}}</td>
        <td style="text-align: center;">{{ $mats->nombre_semestre}}</td>
 
        
    </tr>

  @endforeach
   
  </tbody>
</table>
</br>
   </div>


   @if (count($lista))
   {{ $lista->links() }}
   @endif

   </div>
 @endsection
<script>
function calcula(){
    var ed = document.getElementById('inicio').value; 
    var fecha_inicio = ed.split("-");
    var anio = fecha_inicio[0];
    var mes = fecha_inicio[1];
    var dia = fecha_inicio[2];
  var mm = parseInt(mes);
  var anios= parseInt(anio);
var j=anio;
var hey;
j=anios+1;
if(mes >= 1 || mes <12){
  mm=1+mm;

  hey=mm;
  if(mm >=1 || mm <=9){

  document.getElementById("final").min = anios+'-'+'0'+hey+'-'+dia;
       document.getElementById("hola").value = '2-9 mes cal: '+mm;
  }
if(mm >= 10 || mm < 12){
  document.getElementById("final").min = anios+'-'+hey+'-'+dia;
  document.getElementById("hola").value = '10 - 11 mes cal: '+mm;
}
  if(mm == 12){
  j=anios+1;
  hey=mm;
  document.getElementById("final").min = j+'-'+hey+'-'+dia;
       document.getElementById("hola").value = '12 mes cal: '+mm;
  }
}

  if(mes == 12){
    j=anios+1;
     document.getElementById("hola").value = 'mes: '+mes+' año: '+j;
     document.getElementById("final").min = j+'-'+'01'+'-'+dia;

}
}
//min="<?php echo date("Y-m-d");?>"
</script>










