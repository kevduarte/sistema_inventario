@extends('layouts.plantilla_admin')
@section('title')
:Notificaciones Enviadas
@endsection

 @section('seccion')
 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cuenta docente</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Docentes</a></li>
              <li class="breadcrumb-item active">cuenta</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

 
 <div class="container">

     @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif
 

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Segoe UI';">Cuentas aprobadas</h2>
                                <thead class="thead-dark">
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                       <th   scope="col" >NOMBRE</th>
                                      
                                       <th scope="col">CORREO</th>
                                    
									 
                                     <th scope="col">ASUNTO</th>
                                     <th scope="col">MENSAJE</th>
                                     <th scope="col">OBSERVACIONES</th>
                                     <th   scope="col">FECHA DE ENVIO</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($data as $detalles)
                                    <tr style="color: #000000;">
                                        
                                        <th>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</th>
                                       
                                       
										 <td>{{$detalles->email}}</td>
                                        <td>{{$detalles->asunto}}</td>
                                        <td>{{$detalles->mensaje}}</td>
                                         <td>{{$detalles->estatus}}</td>
                                          <td>{{date("d/m/Y", strtotime($detalles->created_at))}} </td>
                                                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            
                             @if (count($data))
                             {{ $data->links() }}
                             @endif
                             <br />
                         </div>

                         <div class="container">

     @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('mess') }}</strong>
    </div>
    @endif
 

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Segoe UI';">Cuentas rechazadas</h2>
                                <thead class="thead-dark">
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                       <th   scope="col" >NOMBRE</th>
                                      
                                       <th scope="col">CORREO</th>
                                    
                   
                                     <th scope="col">ASUNTO</th>
                                     <th scope="col">MENSAJE</th>
                                     <th scope="col">OBSERVACIONES</th>
                                     <th   scope="col">FECHA DE ENVIO</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($datos as $detalles)
                                    <tr style="color: #000000;">
                                        
                                        <th >{{$detalles->nombre}}</th>
                                       
                                       
                     <td>{{$detalles->email }}</td>
                                        <td>{{$detalles->asunto}}</td>
                                        <td>{{$detalles->mensaje}}</td>
                                         <td>{{$detalles->estatus}}</td>
                                          <td>{{date("d/m/Y", strtotime($detalles->created_at))}} </td>
                                                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            
                             @if (count($data))
                             {{ $data->links() }}
                             @endif
                             <br />
                         </div>
                         @endsection
