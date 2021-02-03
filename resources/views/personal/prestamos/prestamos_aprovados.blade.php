@extends('layouts.plantilla_personal')
@section('title')
:Solicitudes Aprobadas
@endsection
 @section('seccion')
 

 <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Bienvenido </h1>
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
      <div class="alert alert-info">{{ Session::get('message') }}</div>
 @endif


  <table class="table table-bordered table-striped" id="font2"  >
                                 <thead>
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                      <th scope="col">DOCENTE</th>
                                       <th scope="col">GRUPO</th>
                                     
                                     
                                     <th colspan="4" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                 
                                    <tr >
                                      <!--  <td>{{$detalles->num_solicitud}}</td>-->
                                        <td></td>
                                        <td></td>
                                        <td> </td>
                                        <td></td>

                                        <td>  <a>DETALLES</a></td>
                                        <td>  <a >GESTIÓN PRÉSTAMO</a></td>
                                        </tr>
                                      
                                    </tbody>
                                </table>
  

                         </div>
                         @endsection
