@extends('layouts.plantilla_personal')
@section('title')
:detalles solicitud
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
              <li class="breadcrumb-item active">aprobados</li>
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

 <div class="row">
              <div class="col-12" >

                <div class="row">
                  <div class="col">
                  <div class="info-box bg-info">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">GRUPO</span>
                      <span class="info-box-number" align="center">{{$grupo}}</span>
                    </div>
                  </div>
                </div>
                   <div class="col">
                  <div class="info-box bg-primary">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">FECHA DE LA PRÁCTICA</span>
                      <span class="info-box-number" align="center"><?php $date=date_create($fecha_practica);
                                          echo date_format($date,"F j, Y");  ?><span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-success">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">HORA INICIO</span>
                      <span class="info-box-number" align="center"><?php echo date("H:i a", strtotime($inicio)); ?></span>
                    </div>
                  </div>
                </div>
                <div class="col">
                  <div class="info-box bg-danger">
                    <div class="info-box-content">
                      <span class="info-box-text" align="center">HORA FIN</span>
                      <span class="info-box-number" align="center" ><?php echo date("H:i a", strtotime($final)); ?></span>
                    </div>
                  </div>
                </div>
             
              </div>


                </div>
                </div>


  <table class="table table-bordered table-striped" id="font2"  >
       <h2>Vales de reguardo</h2>

                                 <thead>
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                      <th scope="col">NOMBRE BRIGADA</th>
                                       <th scope="col">CUPO BRIGADA</th>
                                       <th scope="col">CURSANDO</th>
                                       <th style=" font-weight:900; " >LUGARES DISPONIBLES</th>
                                       <th style=" font-weight:900; " >ESTADO DEL VALE</th>

                                     
                                     
                                     <th colspan="4" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>

                                      @foreach($detalle as $det)

                                 
                                    <tr >
                                        <td>{{ $det->nombre_brigada}}</td>
                                        <td>{{$det->cupo_brigada}}</td>

                                         <td><?php $inscritos= ($det->cupo_brigada)-($det->control_brigada); echo $inscritos;?></td>
                                        <td>{{$det->control_brigada}}</td>
                                        <td>{{$det->estado_vale}}</td>

                                        <td><a href="/detalles_vale/{{$det->id_vale}}"><button type="button" class="btn btn-primary btn-sm">Detalles <i class="fa fa-bars" aria-hidden="true"></i></button></a></td>

                                    

                                        <td>  <a href="/entregar_vale/{{$det->id_vale}}"><?php if($det->estado_vale=='pendiente'){echo '<button type="button" class="btn btn-warning btn-sm" >Entregar <i class="fa fa-suitcase" aria-hidden="true"></i></button>';}?> </a></td>

                                          <td>  <a href="/liberar_vale/{{$det->id_vale}}"><?php if($det->estado_vale=='en curso'){echo '<button type="button" class="btn btn-success btn-sm" onclick="preguntar(event)">Liberar <i class="fa fa-check" aria-hidden="true"></i></button>';}?> </a></td>

                                           <td>  <a  href="/retener_vale/{{$det->id_vale}}"><?php if($det->estado_vale=='en curso'){echo '<button type="button" class="btn btn-danger btn-sm" onclick="preguntar(event)">Retener <i class="fa fa-ban" aria-hidden="true"></i></button>';}?> </a></td>



                                        </tr>
                                          @endforeach
                                    </tbody>
                                </table>
  
                                {{ $detalle->links() }}
                         </div>
                         @endsection


                         <script type="text/javascript">
                           function enviar() {
  alert('enviado');
}

function preguntar(event) {
  var opcion = confirm("Desea enviar el formulario");
  if(!opcion) {
    event.preventDefault();
  }
}

                         </script>
