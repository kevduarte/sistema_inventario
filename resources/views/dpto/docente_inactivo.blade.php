@extends('layouts.plantilla_dpto')
@section('title')
: Docentes inactivos
@endsection

@section('seccion')

<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Docentes Inactivos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Docente</a></li>
              <li class="breadcrumb-item active">inactivos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="container">

       @if (Session::has('message'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ Session::get('message') }}</strong>
    </div>
    @endif

    <table class="table table-bordered" id="font2">
      <h2 style= "font-family: 'Initial';">Cuentas de docente inactivas</h2>

       <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">NOMBRE DE USUARIO</th>
    
      <th colspan="1">ACCIONES</th>
    </tr>
  </thead>

   <tbody>
  
    @foreach ($docente as $encargados)
       <tr>
              <th> {{ $encargados->nombre }} {{ $encargados->apellido_paterno }} {{ $encargados->apellido_materno }}</th>
                
              <td>{{ $encargados->username }}</td>
          
            <td><a href="{{ route('activar_docente_dpto',$encargados->id_user)}}">ACTIVAR</a></td>
       
            </tr>
         @endforeach
   
  </tbody>




      </table>
      @if (count($docente))
  {{ $docente->links() }}
@endif

@if($docente->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY CUENTAS DE DOCENTES INACTIVAS</h2>  

 @endif   



      </div>



  @endsection
