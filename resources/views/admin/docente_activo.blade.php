@extends('layouts.plantilla_admin')
@section('title')
: Docentes activos
@endsection

@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Docentes Activos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Docente</a></li>
              <li class="breadcrumb-item active">activos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


   <div class="container">

   @if (Session::has('message'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {{ Session::get('message') }}
    </div>
    @endif
     @if (Session::has('mess'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
     {{ Session::get('mess') }}
    </div>
    @endif


  <table class="table table-bordered" id="font2">
 <h2 style= "font-family: 'Initial';">Lista de docentes del departamento de ciencias de la tierra</h2>   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">NOMBRE DE USUARIO</th>
      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>
   <tbody>
  
    @foreach ($docente as $encargados)
    <tr>
      <th scope="row"> {!! $encargados->nombre !!} {!! $encargados->apellido_paterno !!} {!! $encargados->apellido_materno !!}</th>
      
      <td>{!! $encargados->username !!}</td>
      
      <td><a style="color: red;" href="{{ route('desactivar_docente',$encargados->id_user)}}">Desactivar</a></td>

      <td><a style="color: green;" href="{{ route('restablecer_contra',$encargados->id_user)}}" >Restablecer contraseña</a></td>
      
    </tr>
         @endforeach
   
  </tbody>


  
</table>


@if (count($docente))
  {{ $docente->links() }}
@endif

@if($docente->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY DOCENTES DADOS DE ALTA</h2>  
 @endif   




</div>



  @endsection
