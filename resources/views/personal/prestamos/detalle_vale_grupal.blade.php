@extends('layouts.plantilla_personal')
@section('title')
:detalles vale grupal
@endsection
@section('seccion')


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Detalles de la práctica </h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
           <li class="breadcrumb-item"><a href="#">Prestamos</a></li>
              <li class="breadcrumb-item"><a href="{{route('solicitudes_area')}}">solicitudes</a></li>
              <li class="breadcrumb-item active"><a href="/detalles_solicitud/{{$solicitud}}">detalles_solicitud</a></li>
          <li class="breadcrumb-item active">integrantes</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="container" >

  @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

       @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif
        <div class="table-responsive">

  <table class="table table-bordered table-striped" id="font2"  >
   <h2>VALE DE RESGUARDO POR EL SIGUIENTE EQUIPO </h2>

   <thead>
     <tr>
       <!--<th scope="col">SOLICITUD</th>-->
       <th scope="col">DESCRIPCIÓN</th>
       <th scope="col">N° SERIE</th>





       <th colspan="1" >OBSERVACIONES</th>
       <th colspan="1" >VERIFICAR</th>
     </tr>
   </thead>
   <tbody>

    @foreach($detallemate as $indice =>$det)


    <tr >
      <td>{{ $det->nombre_material}}</td>
      <td>{{$det->num_serie}}</td>



      <td><a href=""><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a></td>
      <td><input type="checkbox" id="si" name="si" value="$indice"></td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $detallemate->links() }}
</div>
<br>

<div class="col-xs-offset-2 col-xs-9"  align="center">

<a href="/entregar_vale_grupal/{{$vales}}/{{$solicitud}}"><?php if ($estado=='pendiente') {

echo "<button type='button' class='btn btn-warning' >Entregar <i class='fa fa-suitcase' aria-hidden='true'></i></button>";
} 
 ?></a>




 


<a href="/liberar_vale_grupal/{{$vales}}/{{$solicitud}}"><?php if ($estado!='pendiente') {
echo "<button type='button' class='btn btn-success' onclick='preguntar(event)'' >Liberar <i class='fa fa-check' aria-hidden='true'></i></button>";
}
?></a>  

<a href="/retener_vale/{{$vales}}/{{$solicitud}}"><?php if ($estado!='pendiente') {
echo "<button type='button' class='btn btn-danger' onclick='preguntar(event)'' >Retener <i class='fa fa-ban'
 aria-hidden='true'></i></button>";
}
?></a>  
 


  

</div>  

</div>





@endsection

 <script type="text/javascript">
                           function enviar() {
  alert('enviado');
}

function preguntar(event) {
  var opcion = confirm("Liberar el vale");
  if(!opcion) {
    event.preventDefault();
  }
}

                         </script>
