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
              <li class="breadcrumb-item"><a href="#">Vales</a></li>
              <li class="breadcrumb-item active">integrantes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
 <div class="container" >

    @if (Session::has('message'))
      <div class="alert alert-info">{{ Session::get('message') }}</div>
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
                                   </tr>
                                 </thead>
                                 <tbody>

                                      @foreach($detallemate as $det)

                                 
                                    <tr >
                                        <td>{{ $det->nombre_material}}</td>
                                        <td>{{$det->num_serie}}</td>

                                        

                                        <td><a href=""><button type="button" class="btn btn-primary btn-sm">VER <i class="fa fa-search" aria-hidden="true"></i></button></a></td>
                                        </tr>
                                          @endforeach
                                    </tbody>
                                </table>
  
                                {{ $detallemate->links() }}

                              </div>
                         </div>

                      <div class="container" >

          <div class="table-responsive">

  <table class="table table-bordered table-striped" id="font2"  >
       <h2>INTEGRANTES DE LA BRIGADA  {{$nombreb}}
 </h2>

                                 <thead>
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                     <th scope="col">N°</th>
                                      <th scope="col">NOMBRE ESTUDIANTE</th>
                                       <th scope="col">N° CONTROL</th>
                                       <th scope="col">CARGO</th>
                                            


                                     
                                     
          
                                   </tr>
                                 </thead>
                                 <tbody>

                                      @foreach($detalle as $indice =>$det)


                                 
                                    <tr >
                                        <td >{{$indice+1}}</td>
                                        <td>{{$det->apellido_paterno}} {{$det->apellido_materno}} {{ $det->nombre}}</td>
                                        <td>{{$det->num_control}}</td>

                                        
                                        <td>{{$det->cargo}}</td>

                                        
                                  
                                        </tr>
                                          @endforeach
                                    </tbody>
                                </table>
  
                                {{ $detalle->links() }}
                              </div>
                         </div>

                         @endsection
