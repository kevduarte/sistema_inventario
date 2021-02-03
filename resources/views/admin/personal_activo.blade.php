@extends('layouts.plantilla_admin')
@section('title')
:Personal activo
@endsection


@section('seccion')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="font-size: 2.0em; font-family:Constantia; font-weight: 900;">Personal activo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Personal</a></li>
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

   <div class="container">



  <table class="table table-bordered" id="font2">
  <h2 style= "font-family: 'Initial';">Lista de usuarios registrados</h2>
   
    <thead class="thead-dark">
    <tr>
      <!-- el codigo lo creara y sera unico-->
      <th scope="col">NOMBRE</th>
      <th scope="col">TIPO</th>
      <th scope="col">NOMBRE DE USUARIO</th>



      <th colspan="2">ACCIONES</th>
    </tr>
  </thead>
  <tbody>
   @foreach ($personal as $encargados)
   <tr>
    <th scope="row"> {!! $encargados->nombre !!} {!! $encargados->apellido_paterno !!} {!! $encargados->apellido_materno !!}</th>
    <td><?php if($encargados->tipo_usuario=='personal'){echo "encargado de área";}else{echo $encargados->tipo_usuario;}?></td>

    <td>{!! $encargados->username !!}</td>

    <td><a href="{{ route('desactivar_personal',$encargados->id_user)}}">DESACTIVAR</a></td>
    <td><a href="{{ route('restablecer_contraseña',$encargados->id_user)}}" >RESTABLECER CONTRASEÑA</a></td>
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
