@extends('layouts.plantilla_admin')
@section('title')
: cuenta docente
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Cuenta docente</h1>
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


  @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif
 


   <div class="container">

   <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Segoe UI';">Relación de solicitudes</h2>
    
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE DOCENTE</th>
      <th scope="col">DEPARTAMENTO</th>
       <th scope="col">CORREO</th>

      <th scope="col">CURP</th>
      <th scope="col">ESTADO</th>
      <th scope="col">FECHA</th>
      <th colspan="4">ACCIONES</th>
    </tr>
  </thead>

   <tbody>
   @foreach ($cuentasp as $cuenta)
   <tr>


 

    <th>{!! $cuenta->nombre !!} {!! $cuenta->apellido_paterno !!} {!! $cuenta->apellido_materno !!}</th>

    <td>{!! $cuenta->departamento !!}</td>
    <td>{!! $cuenta->email !!}</td>
    <td>{!! $cuenta->curp !!}</td>


    <td>{!! $cuenta->estado !!}</td>
    <td>{!! date("d-m-Y H:i a", strtotime($cuenta->created_at))  !!}</td>
      <td align="center"><a href="{{ route('cuenta_aprobar',$cuenta->id_cuenta )}}">Aprobar</a></td>
       <td align="center"><a href="{{ route('cuenta_rechazar',$cuenta->id_cuenta )}}">Rechazar</a></td>
       
     
    </tr>
 @endforeach
   
  </tbody>


  
</table>
@if (count($cuentasp))
  {{ $cuentasp->links() }}
@endif

   
@if($cuentasp->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY SOLICITUDES PARA CUENTAS DE DOCENTES</h2>  

 @endif   
 
 
 
</div>


  @endsection
