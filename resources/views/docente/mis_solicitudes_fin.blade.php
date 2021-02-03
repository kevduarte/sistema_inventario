@extends('layouts.plantilla_docente')
@section('title')
:prestamos finalizados
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1  style="font-size: 2.0em; font-family: 'Constantia'; font-weight: 900;">Prestamos finalizados</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Prestamos</a></li>
              <li class="breadcrumb-item active">finalizados</li>
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

  @if (Session::has('mes'))
  <div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>{{ Session::get('mes') }}</strong>
  </div>
  @endif

  <div class="container" id="font1">
 
    <div class="table-responsive">

  <table class="table table-bordered" id="font5">
   <h2>Relación de solicitudes realizadas durante el semestre {{$semestre}}</h2>
   <thead class="thead-dark">
    <tr>

      <th scope="col">CODIGO</th>
      <th scope="col">FECHA DE APROBACIÓN</th>
      <th scope="col">DÍA DE PRÁCTICA</th>
      <th scope="col">ESTADO</th>
      <th scope="col">GRUPO</th>
  



    </tr>
  </thead>

  <tbody>
    @foreach($solicitudes as $sol)
    <tr>
      <th>{{ $sol->id_solicitud}}</th>
      <td>{{ $sol->fecha_solicitud}}</td>
      <td>{{ $sol->fecha_prestamo}}</td>
      <td>{{ $sol->estado}}</td>
      <td>{{ $sol->grupo}}</td>
     
     

      
    </tr>

    @endforeach

  </tbody>
</table>
{{ $solicitudes->links() }}
</div>

</br>


@if($solicitudes->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:#FFE739;">Aún no ha realizado solicitudes</h2>  

 @endif 

 


</div>



@endsection
