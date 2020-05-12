@extends('layouts.plantilla_admin')
@section('title')
:jefe lab
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Jefe de laboratorio</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Jefe de lab.</a></li>
              <li class="breadcrumb-item active">activos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
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


   <div class="container">

  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Initial';">Lista del personal asignado como jefe de laboratorio</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">NOMBRE DE USUARIO</th>
            <th scope="col">ESTADO</th>




      <th colspan="3">ACCIONES</th>
    </tr>
  </thead>
  <tbody>
   @foreach ($personal as $encargados)
   <tr>
    <th> {!! $encargados->nombre !!} {!! $encargados->apellido_paterno !!} {!! $encargados->apellido_materno !!}</th>
    <td>{!! $encargados->username !!}</td>

<td>{!! $encargados->estado !!}</td>

    <td><a style="color: red;" href="{{ route('desactivar_jefelab',$encargados->id_user)}}"><?php if($encargados->estado=='actual'){echo "Desactivar";}?></a></td>
    <td><a style="color: red;" href="{{ route('activar_jefelab',$encargados->id_user)}}"><?php if($encargados->estado=='anterior'){echo "Activar";}?></a></td>
    <td><a  style="color: green;" href="{{ route('restablecer_contra',$encargados->id_user)}}" ><?php if($encargados->estado=='actual'){echo "Restablecer contraseña";}?></a></td>
  </tr>
  @endforeach
</tbody>



</table>
@if (count($personal))
{{ $personal->links() }}
@endif


@if($personal->count()==0)
<h2 style= "font-family: 'Segoe UI'; font-weight:900; background-color:orange;">NO HAY PERSONAL REGISTRADO</h2>  

 @endif   

   


</div>



  @endsection
